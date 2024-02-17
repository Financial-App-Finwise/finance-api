<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ApiSession;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ], [
            'email.required' => "email_required",
            'email.unique' => "email_taken",
            'password.required' => 'password_required',
            'password.confirmed' => 'password_confirmation_not_match',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => 'false', 'code' => 1, 'message' => implode(", ", $validator->errors()->all())])->setStatusCode(422);
        }

        // User verification
        $code = Str::random(6);

        $user = User::create(array_merge(
            $validator->validated(),
            [
                'password' => bcrypt($request->password),
                'email_verification_code' => $code,
            ]
        ));

        $data['code'] = $code;
        $data['email'] = $request->email;
        $data['title'] = "Verifying mail";
        $data['body'] = "Your email has been registered.";

        try {

            Mail::send('VerifyMail', ['data' => $data], function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
        } catch (Exception $e) {
            return response()->json(['success' => 'false', 'message' => $e->getMessage()]);
        }

        return response()->json([
            "success" => "true",
            'message' => 'User successfully registered'
        ], 201);
    }

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string',
        ]);

        $user = User::where('email', $request->email)
                    ->where('email_verification_code', $request->code)
                    ->first();

        if (!$user) {
            return response()->json(['success' => 'false', 'message' => 'Invalid email or code'], 400);
        }

        // Mark the user's email as verified
        $user->email_verified_at = now();
        $user->email_verification_code = null;
        $user->save();

        return response()->json(['success' => 'true', 'message' => 'Email successfully verified'], 200);
    }

    // public function login(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|email',
    //         'password' => 'required|string|min:8',
    //     ], [
    //         'email.required' => "email_required",
    //         'password.required' => 'password_required',
    //     ]);

    //     $cred_key = 'email';
    //     $email = $request->email;
    //     $password = $request->password;

    //     if ($validator->fails())
    //         return response()->json(['success' => 'false', 'code' => 1, 'message' => implode(", ", $validator->errors()->all())])->setStatusCode(422);


    //     if (!$token = auth('api')->attempt([$cred_key => $email, 'password' => $password])) {
    //         return response()->json(['success' => 'false', 'message' => 'Unauthorized'], 401);
    //     }
    //     $user = auth('api')->user();

    //     $session = ApiSession::firstOrNew([
    //         'device_type' => $request->device_type
    //     ]);

    //     $session->user_id = $user->id;
    //     $session->api_token = $token;
    //     $session->save();

    //     return response()->json([
    //         'success' => 'true',
    //         'api_token' => $token,
    //         'token_type' => 'bearer',
    //         'data' => auth('api')->user()
    //     ]);
    // }

    public function login(Request $request)
    {        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ], [
            'email.required' => "email_required",
            'password.required' => 'password_required',
        ]);

        if ($validator->fails())
        return response()->json(['success' => 'false', 'code' => 1, 'message' => implode(", ", $validator->errors()->all())])->setStatusCode(422);


        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('auth-token')->plainTextToken;

            $session = ApiSession::firstOrNew([
                'device_type' => $request->device_type
            ]);
    
            $session->user_id = $user->id;
            $session->api_token = $token;
            $session->save();

            return response()->json([
                'success' => 'true',
                'api_token' => $token,
                'token_type' => 'bearer',
                'data' => $user
            ]);
        }

        throw ValidationException::withMessages(['email' => ['The provided credentials are incorrect.']]);
    }
    
    // public function logout(Request $request)
    // {
    //     $token = $request->bearerToken();
    //     auth()->logout();

    //     ApiSession::where('api_token', $token)->delete();

    //     return response()->json(['success' => 'true', 'message' => 'User successfully signed out']);
    // }

    public function logout(Request $request)
    {
        // check auth token
        if (!$request->user()) {
            return response()->json(['success' => 'false', 'message' => 'Unauthorized'], 401);
        }
        $request->user()->currentAccessToken()->delete();

        return response()->json(['success' => 'true', 'message' => 'User successfully signed out']);
    }
    
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|confirmed|min:8',
        ], [
            'password.required' => 'password_required',
            'password.confirmed' => 'password_confirmation_not_match',
            'password.min' => 'password_must_be_at_least_8_characters'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => 'false', 'code' => 1, 'message' => implode(", ", $validator->errors()->all())])->setStatusCode(422);
        }

        # find user by bearer token
        $user = $request->user();
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(["success" => 'true', 'message' => 'You have successfully updated the password']);
    }
    public function forgotPasswordCode(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->get();
            if (count($user) > 0) {
                $code = Str::random(6);

                $data['code'] = $code;
                $data['email'] = $request->email;
                $data['title'] = "Password Reset";
                $data['body'] = "Please click on the link below to reset your password.";

                Mail::send('forgetPasswordMail', ['data' => $data], function ($message) use ($data) {
                    $message->to($data['email'])->subject($data['title']);
                });

                // add code to user table "email_verification_code" field
                $user = User::where('email', $request->email)->first();
                $user->email_verification_code = $code;
                $user->save();

                return response()->json(['success' => 'true', 'message' => 'Please check your email to reset the password']);
            } else {
                return response()->json(['success' => 'false', 'message' => 'User not found'])->setStatusCode(404);
            }
        } catch (Exception $e) {
            return response()->json(['success' => 'false', 'message' => $e->getMessage()]);
        }
    }
    public function forgotPasswordReset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'code' => 'required|string',
            'password' => 'required|string|confirmed|min:8',
        ], [
            'email.required' => "email_required",
            'code.required' => "code_required",
            'password.required' => 'password_required',
            'password.confirmed' => 'password_confirmation_not_match',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => 'false', 'code' => 1, 'message' => implode(", ", $validator->errors()->all())])->setStatusCode(422);
        }

        $user = User::where('email', $request->email)
                    ->where('email_verification_code', $request->code)
                    ->first();

        if (!$user) {
            return response()->json(['success' => 'false', 'message' => 'Invalid email or code'], 400);
        }

        $user->password = bcrypt($request->password);
        $user->email_verification_code = null;
        $user->save();

        return response()->json(['success' => 'true', 'message' => 'Password successfully reset'], 200);
    }

}
