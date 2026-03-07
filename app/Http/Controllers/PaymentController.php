<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Registration;
use App\Services\SnippeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
            'customer_address' => 'nullable|string|max:255',
            'customer_city' => 'nullable|string|max:100',
            'customer_state' => 'nullable|string|max:100',
            'customer_postcode' => 'nullable|string|max:20',
            'customer_country' => 'nullable|string|size:2',
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
        $configuredWebhookUrl = config('services.snippe.webhook_url');
        $appUrl = rtrim((string)config('app.url'), '/');
        $fallbackWebhookUrl = preg_replace('/^http:\/\//i', 'https://', $appUrl) . '/api/snippe/webhook';
        $webhookUrl = $configuredWebhookUrl ?: $fallbackWebhookUrl;

        $redirectUrl = config('app.frontend_url') . '/?page=events&payment_id=' . $payment->id;
        $cancelUrl = config('app.frontend_url') . '/?page=events&payment_cancelled=1&payment_id=' . $payment->id;

        $snippeData = [
            'profile_id' => config('services.snippe.profile_id'),
            'amount' => (int) $request->amount,
            'currency' => 'TZS',
            'description' => $request->description,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'allowed_methods' => ['mobile_money', 'qr', 'card'],
            'idempotency_key' => $payment->reference,
            'metadata' => [
                'payment_id' => $payment->id,
                'registration_id' => $registration->id,
            ],
            'redirect_url' => $redirectUrl,
            'webhook_url' => $webhookUrl,
            'expires_in' => 3600,
        ];

        $response = $this->snippeService->createSession($snippeData);

        if ($response && isset($response['checkout_url']) && $response['checkout_url']) {
            $payment->update([
                'checkout_url' => $response['checkout_url'],
                'reference' => $response['reference'] ?? $payment->reference,
            ]);

            return response()->json([
                'status' => 'success',
                'checkout_url' => $response['checkout_url'],
                'payment_id' => $payment->id
            ]);
        }

        $payment->update([
            'status' => 'failed',
        ]);

        $debug = config('app.debug') ? [
            'snippe_error' => $response['error'] ?? null,
            'snippe_http_status' => $response['http_status'] ?? null,
            'snippe_body' => $response['body'] ?? null,
            'snippe_exception' => $response['exception'] ?? null,
        ] : null;

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to initiate payment with Snippe',
            'debug' => $debug,
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
                if ($payment->registration) {
                    $registration = $payment->registration;
                    if (!$registration->event_license_no) {
                        $prefix = 'CT';
                        $year = date('y');
                        do {
                            $candidate = $prefix . '-' . $year . '-' . strtoupper(Str::random(6));
                            $exists = Registration::where('event_id', $registration->event_id)
                                ->where('event_license_no', $candidate)
                                ->exists();
                        } while ($exists);

                        $registration->event_license_no = $candidate;
                    }

                    $registration->status = 'paid';
                    $registration->save();
                }
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
