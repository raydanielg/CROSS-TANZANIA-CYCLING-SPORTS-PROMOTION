<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    /**
     * Handle an incoming registration request for a participant.
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'phone' => ['nullable', 'string', 'max:20'],
                'gender' => ['nullable', 'string', 'in:Male,Female,Other'],
                'date_of_birth' => ['nullable', 'date'],
                'emergency_contact_name' => ['nullable', 'string', 'max:255'],
                'emergency_contact_phone' => ['nullable', 'string', 'max:20'],
                'role' => ['nullable', 'string', 'in:admin,rider'],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Illuminate\Support\Facades\Log::error('Registration validation failed', [
                'errors' => $e->errors(),
                'request' => $request->all(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();
        
        // Ikiwa ni Rider, lazima awe na participant record. Admin haihitaji.
        $role = $request->role ?? 'rider';

        if ($user && $role === 'rider' && $user->participant) {
            return response()->json([
                'message' => 'The email has already been taken.',
                'errors' => ['email' => ['The email has already been taken.']],
            ], 422);
        }

        try {
            return DB::transaction(function () use ($request, $user, $role) {
                if (!$user) {
                    $user = User::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'role' => $role,
                        'is_verified' => true,
                    ]);
                } else {
                    $user->update([
                        'name' => $request->name,
                        'password' => Hash::make($request->password),
                        'role' => $role,
                        'is_verified' => true,
                        'otp' => null,
                        'otp_expires_at' => null,
                    ]);
                }

                if ($role === 'rider') {
                    $participant = Participant::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'phone' => $request->phone,
                            'gender' => $request->gender,
                            'date_of_birth' => $request->date_of_birth,
                            'emergency_contact_name' => $request->emergency_contact_name,
                            'emergency_contact_phone' => $request->emergency_contact_phone,
                            'status' => 'active',
                        ]
                    );

                    // Rekodi usajili mpya kwa ajili ya admin panel
                    $event = \App\Models\Event::where('status', 'upcoming')->first();
                    if ($event) {
                        \App\Models\Registration::updateOrCreate(
                            ['participant_id' => $participant->id, 'event_id' => $event->id],
                            ['status' => 'pending']
                        );
                    }
                }

                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'message' => 'Registration successful.',
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role,
                        'is_verified' => true,
                        'participant' => $user->participant,
                    ],
                    'token' => $token,
                    'token_type' => 'Bearer',
                    'redirect_to' => $user->role === 'admin' ? '/admin/dashboard' : '/dashboard',
                ], 201);
            });
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
