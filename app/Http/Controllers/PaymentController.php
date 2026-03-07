<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Registration;
use App\Services\SnippeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $snippeService;

    public function __construct(SnippeService $snippeService)
    {
        $this->snippeService = $snippeService;
    }

    /**
     * Initiate a payment request
     */
    public function initiate(Request $request)
    {
        $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'amount' => 'required|numeric|min:1',
            'description' => 'required|string',
            'customer_name' => 'required|string',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
            'channel' => 'nullable|in:mobile,card,dynamic-qr',
        ]);

        $registration = Registration::findOrFail($request->registration_id);

        // Create a pending payment record
        $payment = Payment::create([
            'user_id' => auth()->id(),
            'registration_id' => $registration->id,
            'amount' => $request->amount,
            'currency' => 'TZS',
            'description' => $request->description,
            'method' => 'snippe',
            'status' => 'pending',
            'reference' => 'PENDING_' . uniqid(),
            'metadata' => [
                'registration_id' => $registration->id,
                'event_id' => $registration->event_id,
            ],
        ]);

        // Request checkout from Snippe
        $snippeData = [
            'amount' => (int) $request->amount,
            'currency' => 'TZS',
            'channel' => $request->input('channel', 'card'),
            'description' => $request->description,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'idempotency_key' => $payment->reference,
            'metadata' => [
                'payment_id' => $payment->id,
                'registration_id' => $registration->id,
            ],
            'redirect_url' => config('app.frontend_url') . '/payment/success?payment_id=' . $payment->id,
            'webhook_url' => route('snippe.webhook'),
        ];

        $response = $this->snippeService->createPayment($snippeData);

        if ($response && isset($response['payment_url']) && $response['payment_url']) {
            $payment->update([
                'checkout_url' => $response['payment_url'],
                'reference' => $response['reference'] ?? $payment->reference,
            ]);

            return response()->json([
                'status' => 'success',
                'checkout_url' => $response['payment_url'],
                'payment_id' => $payment->id
            ]);
        }

        $payment->update([
            'status' => 'failed',
        ]);

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to initiate payment with Snippe'
        ], 500);
    }

    /**
     * Handle Snippe Webhook
     */
    public function webhook(Request $request)
    {
        $payload = $request->all();
        $rawBody = $request->getContent();
        $signature = $request->header('X-Webhook-Signature');
        $timestamp = $request->header('X-Webhook-Timestamp');

        Log::info('Snippe Webhook Received', [
            'headers' => [
                'X-Webhook-Event' => $request->header('X-Webhook-Event'),
                'X-Webhook-Timestamp' => $timestamp,
            ],
            'payload' => $payload,
        ]);

        // Verify webhook signature if secret configured
        if (!$this->snippeService->verifyWebhook([
            'raw_body' => $rawBody,
            'timestamp' => $timestamp,
        ], $signature)) {
            return response()->json(['message' => 'Invalid signature'], 400);
        }

        $type = $payload['type'] ?? '';
        $data = $payload['data'] ?? [];
        $reference = $data['reference'] ?? null;
        $paymentId = $data['metadata']['payment_id'] ?? null;

        $payment = null;
        if ($paymentId) {
            $payment = Payment::find($paymentId);
        } elseif ($reference) {
            $payment = Payment::where('reference', $reference)->first();
        }

        if (!$payment) {
            Log::warning('Payment not found for webhook', $payload);
            return response()->json(['message' => 'Payment not found'], 404);
        }

        $payment->update(['webhook_status' => $type]);

        switch ($type) {
            case 'payment.completed':
                $payment->update([
                    'status' => 'completed',
                    'paid_at' => now(),
                ]);
                // Update registration status if needed
                $payment->registration->update(['status' => 'paid']);
                break;

            case 'payment.failed':
                $payment->update(['status' => 'failed']);
                break;

            case 'payment.pending':
                $payment->update(['status' => 'pending']);
                break;
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Check payment status (Polling for frontend if needed)
     */
    public function status($id)
    {
        $payment = Payment::findOrFail($id);
        return response()->json([
            'status' => $payment->status,
            'reference' => $payment->reference
        ]);
    }
}
