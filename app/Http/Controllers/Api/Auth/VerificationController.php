<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class VerificationController extends Controller
{
    /**
     * Tuma OTP mpya kwa mtumiaji.
     */
    public function sendOtp(Request $request): JsonResponse
    {
        $user = $request->user();
        
        // Tengeneza OTP ya tarakimu 6
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        // Hapa tunatakiwa kutuma kwa Email au SMS
        // Kwa sasa tuna-log ili uweze kuiona kwenye storage/logs/laravel.log
        Log::info("OTP for User {$user->email}: {$otp}");
        error_log("------------------------------------------");
        error_log("NEW OTP GENERATED FOR: " . $user->email);
        error_log("OTP CODE: " . $otp);
        error_log("------------------------------------------");

        return response()->json([
            'message' => 'OTP has been sent to your email/phone.',
            // Katika production, usirudishe OTP kwenye response!
            'debug_otp' => config('app.debug') ? $otp : null, 
        ]);
    }

    /**
     * Hakiki OTP iliyotumwa.
     */
    public function verifyOtp(Request $request): JsonResponse
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $user = $request->user();

        if ($user->otp !== $request->otp || now()->gt($user->otp_expires_at)) {
            return response()->json([
                'message' => 'Invalid or expired OTP.',
                'errors' => ['otp' => ['The OTP is invalid or has expired.']]
            ], 422);
        }

        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
            'is_verified' => true,
        ]);

        return response()->json([
            'message' => 'Account verified successfully.',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_verified' => true,
                'role' => $user->role,
            ]
        ]);
    }
}
