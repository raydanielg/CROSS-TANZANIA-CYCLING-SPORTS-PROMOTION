<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class PaymentTicketController extends Controller
{
    public function show(Request $request, Payment $payment)
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

        $payment->load(['registration.event', 'registration.participant', 'registration.participant.user']);

        $registration = $payment->registration;
        if (!$registration || !$registration->participant) {
            abort(404);
        }

        $participant = $registration->participant;
        if ((int) $participant->user_id !== (int) $user->id) {
            abort(403);
        }

        return response()
            ->view('tickets.registration', [
                'user' => $user,
                'participant' => $participant,
                'registration' => $registration,
                'event' => $registration->event,
                'payment' => $payment,
            ])
            ->header('Content-Type', 'text/html; charset=UTF-8');
    }
}
