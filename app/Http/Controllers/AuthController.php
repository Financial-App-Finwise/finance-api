<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\V1\RegisterRequest;
use App\Http\Requests\V1\VerifyEmailRequest;
use App\Http\Requests\V1\LoginRequest;
use App\Http\Requests\V1\ResetPasswordRequest;
use App\Http\Requests\V1\ForgotPasswordCodeRequest;
use App\Http\Requests\V1\ForgotPasswordResetRequest;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use App\Models\MyFinance;
use App\Models\UserOnboardingInfo;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $code = Str::random(6);

        $user = User::create(array_merge(
            $request->validated(),
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
        } catch (\Exception $e) {
            return response()->json(['success' => 'false', 'message' => $e->getMessage()], 500);
        }

        return response()->json([
            'success' => 'true',
            'message' => 'User successfully registered'
        ], 201);
    }

    public function verifyEmail(VerifyEmailRequest $request)
    {
        $user = User::where('email', $request->email)
                    ->where('email_verification_code', $request->code)
                    ->first();

        if (!$user) {
            return response()->json([
                'success' => 'false',
                'message' => 'Invalid email or code'
            ], 400);
        }

        $user->email_verified_at = now();
        $user->email_verification_code = null;
        $user->save();

        return response()->json([
            'success' => 'true',
            'message' => 'Email successfully verified'
        ], 200);
    }

    public function login(LoginRequest $request)
    {        
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'success' => 'true',
                'api_token' => $token,
                'token_type' => 'bearer',
                'data' => $user
            ], 200);
        }

        return response()->json([
            'success' => 'false',
            'message' => 'The provided credentials are incorrect.'
        ], 422);
    }

    public function logout(Request $request)
    {
        if (!$request->user()) {
            return response()->json([
                'success' => 'false',
                'message' => 'Unauthorized'
            ], 401);
        }

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => 'true',
            'message' => 'User successfully signed out'
        ], 200);
    }
    
    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = $request->user();
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'success' => 'true',
            'message' => 'You have successfully updated the password'
        ], 200);
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

                $user = User::where('email', $request->email)->first();
                $user->email_verification_code = $code;
                $user->save();

                return response()->json([
                    'success' => 'true',
                    'message' => 'Please check your email to reset the password'
                ], 200);
            } else {
                return response()->json([
                    'success' => 'false',
                    'message' => 'User not found'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => 'false',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function forgotPasswordReset(ForgotPasswordResetRequest $request)
    {
        $user = User::where('email', $request->email)
                    ->where('email_verification_code', $request->code)
                    ->first();

        if (!$user) {
            return response()->json([
                'success' => 'false',
                'message' => 'Invalid email or code'
            ], 400);
        }

        $user->password = bcrypt($request->password);
        $user->email_verification_code = null;
        $user->save();

        return response()->json([
            'success' => 'true',
            'message' => 'Password successfully reset'
        ], 200);
    }
}
