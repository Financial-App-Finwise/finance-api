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
    /**
     * Register a new user.
     *
     * @param \Illuminate\Http\Request\RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        // Validate user input
        $validatedData = $request->validated();

        // Check if the user with the given email already exists
        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                'success' => 'false',
                'message' => 'User with this email already exists'
            ], 400);
        }
    
        // Generate a random verification code.
        $code = Str::random(6);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'email_verification_code' => $code,
        ]);
    
        // Prepare email data.
        $data['code'] = $code;
        $data['email'] = $request->email;
        $data['title'] = "Verifying mail";
        $data['body'] = "Your email has been registered.";
    
        try {
            // Send verification email.
            Mail::send('VerifyMail', ['data' => $data], function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
        } catch (\Exception $e) {
            // Return error response if sending email fails.
            return response()->json(['success' => 'false', 'message' => $e->getMessage()], 500);
        }
    
        // Return success response upon successful registration.
        return response()->json([
            'success' => 'true',
            'message' => 'User successfully registered'
        ], 201);
    }

    /**
     * Verify a user's email.
     *
     * @param \Illuminate\Http\Request\VerifyEmailRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyEmail(VerifyEmailRequest $request)
    {
        // Find the user by email and verification code.
        $user = User::where('email', $request->email)
                    ->where('email_verification_code', $request->code)
                    ->first();

        // If user not found, return error response.
        if (!$user) {
            return response()->json([
                'success' => 'false',
                'message' => 'Invalid email or code'
            ], 400);
        }

        // Mark the email as verified and remove verification code.
        $user->email_verified_at = now();
        $user->email_verification_code = null;
        $user->save();

        // Return success response upon successful verification.
        return response()->json([
            'success' => 'true',
            'message' => 'Email successfully verified'
        ], 200);
    }

    /**
     * Authenticate a user and generate a new API token upon successful login.
     *
     * @param \Illuminate\Http\Request\LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {        
        // Attempt to authenticate user with provided credentials.
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Retrieve authenticated user.
            $user = Auth::user();
            // Generate a new API token for the user.
            $token = $user->createToken('auth-token')->plainTextToken;

            // Return success response with API token and user data.
            return response()->json([
                'success' => 'true',
                'api_token' => $token,
                'token_type' => 'bearer',
                'data' => $user
            ], 200);
        }

        // Return error response if authentication fails.
        return response()->json([
            'success' => 'false',
            'message' => 'The provided credentials are incorrect.'
        ], 422);
    }

    /**
     * Revoke the user's current access token, effectively logging them out.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // Check if the user is authenticated.
        if (!$request->user()) {
            // Return error response if the user is not authenticated.
            return response()->json([
                'success' => 'false',
                'message' => 'Unauthorized'
            ], 401);
        }

        // Revoke the user's current access token.
        $request->user()->currentAccessToken()->delete();

        // Return success response upon successful logout.
        return response()->json([
            'success' => 'true',
            'message' => 'User successfully signed out'
        ], 200);
    }
    
    /**
     * Reset the password for the authenticated user.
     *
     * @param \Illuminate\Http\Request\ResetPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        // Retrieve the authenticated user.
        $user = $request->user();
        
        // Update the user's password with the hashed new password.
        $user->password = bcrypt($request->password);
        $user->save();

        // Return success response upon successful password update.
        return response()->json([
            'success' => 'true',
            'message' => 'You have successfully updated the password'
        ], 200);
    }

    /**
     * Send a password reset code to the user's email.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPasswordCode(Request $request)
    {
        try {
            // Find the user by email.
            $user = User::where('email', $request->email)->get();
            
            // If user exists, send a password reset code.
            if (count($user) > 0) {
                // Generate a random reset code.
                $code = Str::random(6);

                // Prepare email data.
                $data['code'] = $code;
                $data['email'] = $request->email;
                $data['title'] = "Password Reset";
                $data['body'] = "Please click on the link below to reset your password.";

                // Send password reset email.
                Mail::send('forgetPasswordMail', ['data' => $data], function ($message) use ($data) {
                    $message->to($data['email'])->subject($data['title']);
                });

                // Update user's email verification code.
                $user = User::where('email', $request->email)->first();
                $user->email_verification_code = $code;
                $user->save();

                // Return success response.
                return response()->json([
                    'success' => 'true',
                    'message' => 'Please check your email to reset the password'
                ], 200);
            } else {
                // Return error response if user not found.
                return response()->json([
                    'success' => 'false',
                    'message' => 'User not found'
                ], 404);
            }
        } catch (\Exception $e) {
            // Return error response if an exception occurs.
            return response()->json([
                'success' => 'false',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reset the password for the user using the provided reset code.
     *
     * @param \Illuminate\Http\Request\ForgotPasswordResetRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPasswordReset(ForgotPasswordResetRequest $request)
    {
        // Find the user by email and reset code.
        $user = User::where('email', $request->email)
                    ->where('email_verification_code', $request->code)
                    ->first();

        // If user not found, return error response.
        if (!$user) {
            return response()->json([
                'success' => 'false',
                'message' => 'Invalid email or code'
            ], 400);
        }

        // Update the user's password and clear the verification code.
        $user->password = bcrypt($request->password);
        $user->email_verification_code = null;
        $user->save();

        // Return success response upon successful password reset.
        return response()->json([
            'success' => 'true',
            'message' => 'Password successfully reset'
        ], 200);
    }
}
