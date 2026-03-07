<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class PaymentReceiptController extends Controller
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

        if ((int) $registration->participant->user_id !== (int) $user->id) {
            abort(403);
        }

        return response()->json([
            'payment' => [
                'id' => $payment->id,
                'amount' => $payment->amount,
                'currency' => $payment->currency ?? 'TZS',
                'reference' => $payment->reference,
                'method' => $payment->method,
                'status' => $payment->status,
                'paid_at' => $payment->paid_at,
            ],
            'registration' => [
                'id' => $registration->id,
                'status' => $registration->status,
                'bib_number' => $registration->bib_number,
                'event_license_no' => $registration->event_license_no,
                'created_at' => $registration->created_at,
            ],
            'event' => [
                'id' => $registration->event->id ?? null,
                'name' => $registration->event->name ?? null,
                'event_date' => $registration->event->event_date ?? null,
                'location' => $registration->event->location ?? null,
                'distance_km' => $registration->event->distance_km ?? null,
            ],
            'participant' => [
                'id' => $registration->participant->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }
}
