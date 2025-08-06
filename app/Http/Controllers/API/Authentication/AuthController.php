<?php

namespace App\Http\Controllers\API\Authentication;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPassword;
use App\Mail\PasswordResetMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Custom validation rules
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // If validation fails, return the errors with a 422 Unprocessable Entity status code
        if ($validator->fails()) {
            return Helper::jsonErrorResponse('Profile Update Validation failed', 422, $validator->errors()->toArray());
        }

        // Retrieve credentials from the validated data
        $credentials = $request->only('email', 'password');

        // Attempt to authenticate using JWTAuth
        $token = JWTAuth::attempt($credentials);

        // If token is not generated, return an unauthorized error
        if (!$token) {
            return Helper::jsonErrorResponse('Unauthorized', 401);
        }

        // Fetch the authenticated user using JWTAuth
        $user = JWTAuth::user();

        // Return successful login response with user details and token
        return Helper::jsonResponse(true, 'Login Successfully', 200, [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'avatar' => $user->avatar,
                'phone' => $user->phone
            ],
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }


    public function register(Request $request)
    {
        // Custom validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // If validation fails, return a 422 Unprocessable Entity response with errors
        if ($validator->fails()) {
            return Helper::jsonErrorResponse('Profile Update Validation failed', 422, $validator->errors()->toArray());
        }

        // Create the user record
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hashing the password
        ]);

        // Generate the JWT token for the user
        // $token = JWTAuth::fromUser($user);

        // Return success response with user data and JWT token
        return Helper::jsonResponse(true, 'Registration successfully done', 201, $user);
    }


    public function logout()
    {
        $user = JWTAuth::user();
        JWTAuth::invalidate(JWTAuth::getToken());
        return Helper::jsonResponse(true, 'Successfully logged out', 200, [
            'user name' => $user->name,
        ]);
    }


    //for new token create
    public function refresh()
    {
        $newToken = JWTAuth::refresh(JWTAuth::getToken());
        return Helper::jsonResponse(true, 'New token generated', 200, [
            'user' => [
                'id' => JWTAuth::user()->id,
                'name' => JWTAuth::user()->name,
                'email' => JWTAuth::user()->email,
                'avatar' => JWTAuth::user()->avatar,
                'role' => JWTAuth::user()->role,
                'phone' => JWTAuth::user()->phone,
            ],
            'authorisation' => [
                'token' => $newToken,
                'type' => 'bearer',
            ]
        ]);
    }

    //Account Delete functions
    public function deleteAccount(Request $request)
    {
        $user = $request->user();

        // Revoke all tokens before deleting the account
        $user->tokens()->delete();

        // Delete the user account
        $user->delete();

        return Helper::jsonResponse(true, 'Account deleted successfully', 200, ['user name' => $user->name]);
    }

    public function ProfileUpdate(Request $request)
    {
        // Get the currently authenticated user
        $authenticatedUser = auth()->user();
        if (!$authenticatedUser) {
            return Helper::jsonErrorResponse('Unauthenticated', 401);
        }

        // Custom validation rules for profile update
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $authenticatedUser->id,
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'cover_photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5242880',
            'phone' => 'nullable|string|min:5|max:20',
            'position' => 'nullable|string|max:255',
            'about' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'flag' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:255',
        ]);

        // If validation fails, return a 422 response with error messages
        if ($validator->fails()) {
            return Helper::jsonErrorResponse('Profile Update Validation failed', 422, $validator->errors()->toArray());
        }

        // Update the user's profile information
        $authenticatedUser->name = $request->name;
        $authenticatedUser->email = $request->email;
        $authenticatedUser->phone = $request->phone;
        $authenticatedUser->position = $request->position;
        $authenticatedUser->about = $request->about;
        $authenticatedUser->address = $request->address;
        $authenticatedUser->country = $request->country;
        $authenticatedUser->city = $request->city;
        $authenticatedUser->state = $request->state;
        $authenticatedUser->zip_code = $request->zip_code;

        //  avatar
        if ($request->hasFile('avatar')) {
            // Delete old avatar if it exists
            if ($authenticatedUser->avatar) {
                Helper::fileDelete(public_path($authenticatedUser->avatar));
            }

            // Upload new avatar using the Helper::fileUpload method
            $avatar = $request->file('avatar');
            $avatarName = $authenticatedUser->id . '_avatar'; // Use user ID for uniqueness
            $avatarPath = Helper::fileUpload($avatar, 'profile/avatar', $avatarName);

            // Save the path of the avatar in the database
            $authenticatedUser->avatar = $avatarPath;
        }

        // cover_photo
        if ($request->hasFile('cover_photo')) {
            // Delete old cover_photo if it exists
            if ($authenticatedUser->cover_photo) {
                Helper::fileDelete(public_path($authenticatedUser->cover_photo));
            }

            // Upload new cover_photo using the Helper::fileUpload method
            $cover_photo = $request->file('cover_photo');
            $cover_photoName = $authenticatedUser->id . '_cover_photo'; // Use user ID for uniqueness
            $cover_photoPath = Helper::fileUpload($cover_photo, 'profile/cover_photo', $cover_photoName);

            // Save the path of the cover_photo in the database
            $authenticatedUser->cover_photo = $cover_photoPath;
        }

        // flag
        if ($request->hasFile('flag')) {
            // Delete old flag if it exists
            if ($authenticatedUser->flag) {
                Helper::fileDelete(public_path($authenticatedUser->flag));
            }

            // Upload new flag using the Helper::fileUpload method
            $flag = $request->file('flag');
            $flagName = $authenticatedUser->id . '_flag'; // Use user ID for uniqueness
            $flagPath = Helper::fileUpload($flag, 'profile/flag', $flagName);

            // Save the path of the flag in the database
            $authenticatedUser->flag = $flagPath;
        }

        // Save the updated user data
        $authenticatedUser->save();

        // Return success response with the updated user data
        return Helper::jsonResponse(true, 'Profile updated successfully', 200, $authenticatedUser->only(['name', 'email', 'avatar', 'cover_photo', 'role', 'phone', 'position', 'about', 'address', 'country', 'flag', 'city', 'state', 'zip_code']));
    }

    // password change
    public function ChangePassword(Request $request)
    {
        // Create custom validator using Validator facade
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return Helper::jsonErrorResponse('Profile Update Validation failed', 422, $validator->errors()->toArray());
        }

        // Authenticate the user using JWT
        $user = JWTAuth::parseToken()->authenticate();

        if (!$user) {
            return Helper::jsonErrorResponse('User not found or unauthorized', 401);
        }

        // Check if the old password matches the current password
        if (!Hash::check($request->old_password, $user->password)) {
            return Helper::jsonErrorResponse('Old password is incorrect', 400);
        }

        // Hash the new password and save it to the database
        $user->password = Hash::make($request->password);
        $user->save();

        return Helper::jsonResponse(true, 'Password changed successfully', 200, $user->only(['name', 'email', 'phone', 'avatar']));
    }



    // Forgot Password API - send OTP to email
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return Helper::jsonErrorResponse('Profile Update Validation failed', 422, $validator->errors()->toArray());
        }

        // Find user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return Helper::jsonErrorResponse('No user found with this email address.', 404);
        }

        // Generate a 6-digit reset token
        $token = rand(100000, 999999);

        // Store the token and expiry time in the database
        $user->password_reset_token = $token;
        $user->password_reset_token_expiry = now()->addMinutes(5);  // Token expires after 5 minutes
        $user->save();

        // Send token to the user's email (using Queue)
        Mail::to($user->email)->queue(new PasswordResetMail($token));

        return Helper::jsonResponse(true, 'Password reset OTP has been sent to your email.', 200, ['OTP' => $user->password_reset_token]);
    }



    // OTP Verification API - Verify OTP sent to email
    public function verifyOtp(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return Helper::jsonErrorResponse('Profile Update Validation failed', 422, $validator->errors()->toArray());
        }

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return Helper::jsonErrorResponse('No user found with this email address.', 404);
        }

        // Check if the OTP matches
        if ($user->password_reset_token !== $request->otp) {
            return Helper::jsonErrorResponse('Invalid OTP.', 400);
        }

        // Check if the OTP has expired
        if ($user->password_reset_token_expiry < now()) {
            return Helper::jsonErrorResponse('OTP has expired.', 400);
        }

        // OTP is valid, proceed to allow password reset
        return Helper::jsonResponse(true, 'OTP verified successfully. You can now reset your password.', 200);
    }



    // Password Reset API - Reset user password
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return Helper::jsonErrorResponse('Profile Update Validation failed', 422, $validator->errors()->toArray());
        }

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return Helper::jsonErrorResponse('No user found with this email address.', 404);
        }

        // Check if OTP verification is done
        if ($user->password_reset_token === null || $user->password_reset_token_expiry < now()) {
            return Helper::jsonErrorResponse('OTP verification failed or expired. Please request a new OTP.', 400);
        }

        // If OTP is verified and not expired, proceed with password reset
        $user->password = Hash::make($request->password); // Hash the new password
        $user->password_reset_token = null; // Clear the token after password reset
        $user->password_reset_token_expiry = null; // Clear the expiry
        $user->save();

        return Helper::jsonResponse(true, 'Password has been successfully reset.', 200);
    }


    // Resend OTP API - resend OTP to email if expired or not sent previously
    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return Helper::jsonErrorResponse('Profile Update Validation failed', 422, $validator->errors()->toArray());
        }

        // Find user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return Helper::jsonErrorResponse('No user found with this email address.', 404);
        }

        // Generate a new 6-digit reset token
        $token = rand(100000, 999999);

        // Store the new token and set expiry time
        $user->password_reset_token = $token;
        $user->password_reset_token_expiry = now()->addMinutes(5);  // Token expires after 5 minutes
        $user->save();

        // Send the new token to the user's email
        Mail::to($user->email)->queue(new PasswordResetMail($token));

        return Helper::jsonResponse(true, 'A new password reset OTP has been sent to your email.', 200, ['OTP' => $token]);
    }


    public function ProfileGet(Request $request)
    {
        try {
            $user = auth()->user();


            // Get the subscription instance for the 'default' plan
            $subscription = $user->subscription('default');

            // Calculate remaining days if subscription exists and has an end date
            $remainingDays = $subscription && $subscription->ends_at
                ? now()->diffInDays($subscription->ends_at, false)
                : null;

            return Helper::jsonResponse(true, 'User profile retrieved successfully.', 200, [
                'avatar' => $user->avatar,
                'cover_photo' => $user->cover_photo,
                'email' => $user->email,
                'name' => $user->name,
                'phone' => $user->phone,
                'country' => $user->country,
                'flag' => $user->flag,
                'is_subscribed' => $user->subscribed('default'),
                'subscription_status' => $subscription?->paystack_status ?? null, // Use paystack_status if using Paystack
                'plan_code' => $subscription?->paystack_plan ?? null, // Optional, if stored in DB
                // 'ends_at' => $subscription?->ends_at,
                // 'remaining_days' => $remainingDays,
            ]);
        } catch (\Exception $e) {
            return Helper::jsonErrorResponse($e->getMessage(), 500);
        }
    }
}
