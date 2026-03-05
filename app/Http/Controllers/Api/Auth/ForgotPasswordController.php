<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rules;

class ForgotPasswordController extends Controller
{
    /**
     * Send OTP for password reset.
     */
    public function sendResetOtp(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();
        
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(15),
        ]);

        Log::info("Password Reset OTP for User {$user->email}: {$otp}");
        error_log("------------------------------------------");
        error_log("PASSWORD RESET OTP FOR: " . $user->email);
        error_log("OTP CODE: " . $otp);
        error_log("------------------------------------------");

        return response()->json([
            'message' => 'Password reset code has been sent to your email.',
            'debug_otp' => config('app.debug') ? $otp : null,
        ]);
    }

    /**
     * Reset password using OTP.
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|string|size:6',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->otp !== $request->otp || now()->gt($user->otp_expires_at)) {
            return response()->json([
                'message' => 'Invalid or expired reset code.',
                'errors' => ['otp' => ['The reset code is invalid or has expired.']]
            ], 422);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'otp' => null,
            'otp_expires_at' => null,
        ]);

        return response()->json([
            'message' => 'Password has been reset successfully.',
        ]);
    }
}
