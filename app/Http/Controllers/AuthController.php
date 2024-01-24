<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
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
            return response()->json(['result' => 'fail', 'code' => 1, 'message' => implode(", ", $validator->errors()->all())])->setStatusCode(422);
        }


        // User verification
        $code = Str::random(40);

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
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
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
            return response()->json(['message' => 'Invalid email or code'], 400);
        }

        // Mark the user's email as verified
        $user->email_verified_at = now();
        $user->email_verification_code = null;
        $user->save();

        return response()->json(['message' => 'Email successfully verified'], 200);
    }

    public function test(Request $request)
    {
        return response()->json([
            'message' => 'User successfully registered',
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ], [
            'email.required' => "email_required",
            'password.required' => 'password_required',
        ]);

        $cred_key = 'email';
        $email = $request->email;
        $password = $request->password;

        if ($validator->fails())
            return response()->json(['result' => 'fail', 'code' => 1, 'message' => implode(", ", $validator->errors()->all())])->setStatusCode(422);


        if (!$token = auth('api')->attempt([$cred_key => $email, 'password' => $password])) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = auth('api')->user();

        return $this->createNewToken($token);
    }


    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth('api')->user()
        ]);
    }


}
