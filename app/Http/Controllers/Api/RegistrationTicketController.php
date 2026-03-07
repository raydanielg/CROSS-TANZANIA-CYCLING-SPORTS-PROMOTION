<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class RegistrationTicketController extends Controller
{
    public function show(Request $request, Registration $registration)
    {
        $user = $request->user();

        if (!$user) {
            $token = (string) $request->query('token', '');
            if ($token) {
                $accessToken = PersonalAccessToken::findToken($token);
                if ($accessToken) {
                    $user = $accessToken->tokenable;
                }
            }
        }

        if (!$user) {
            abort(401);
        }

        $participant = $user->participant;
        if (!$participant || (int) $registration->participant_id !== (int) $participant->id) {
            abort(403);
        }

        $registration->load(['event', 'payment']);

        return response()
            ->view('tickets.registration', [
                'user' => $user,
                'participant' => $participant,
                'registration' => $registration,
                'event' => $registration->event,
                'payment' => $registration->payment,
            ])
            ->header('Content-Type', 'text/html; charset=UTF-8');
    }
}
