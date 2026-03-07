<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SnippeService
{
    protected $apiKey;
    protected $baseUrl;
    protected $webhookSecret;

    public function __construct()
    {
        $this->apiKey = \App\Models\Setting::get('snippe_api_key', config('services.snippe.api_key'));
        $this->baseUrl = \App\Models\Setting::get('snippe_base_url', config('services.snippe.base_url', 'https://api.snippe.sh'));
        $this->webhookSecret = \App\Models\Setting::get('snippe_webhook_secret', config('services.snippe.webhook_secret'));
    }

    /**
     * Create a payment request with Snippe
     */
    public function createPayment(array $data)
    {
        try {
            $idempotencyKey = $data['idempotency_key'] ?? ('payment-' . Str::uuid()->toString());
            $baseUrl = rtrim($this->baseUrl, '/');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'Idempotency-Key' => $idempotencyKey,
            ])->post($baseUrl . '/v1/payments', [
                'amount' => (int) $data['amount'],
                'currency' => $data['currency'] ?? 'TZS',
                'channel' => $data['channel'] ?? 'card',
                'customer' => [
                    'name' => $data['customer_name'],
                    'phone' => $data['customer_phone'],
                    'email' => $data['customer_email'],
                ],
                'description' => $data['description'],
                'webhook_url' => $data['webhook_url'],
                'redirect_url' => $data['redirect_url'] ?? null,
                'metadata' => $data['metadata'] ?? [],
            ]);

            if ($response->successful()) {
                $json = $response->json();

                // Snippe docs: { status: success|error, code: 200, data: {} }
                if (is_array($json) && ($json['status'] ?? null) === 'success') {
                    $dataPayload = $json['data'] ?? [];

                    return [
                        'raw' => $json,
                        'reference' => $dataPayload['reference'] ?? null,
                        'payment_url' => $dataPayload['payment_url'] ?? $dataPayload['checkout_url'] ?? null,
                        'payment_qr_code' => $dataPayload['payment_qr_code'] ?? null,
                        'status' => $dataPayload['status'] ?? null,
                    ];
                }

                return [
                    'raw' => $json,
                    'error' => $json['message'] ?? 'Snippe responded without success status',
                ];
            }

            Log::error('Snippe Payment Creation Failed', [
                'status' => $response->status(),
                'body' => $response->body(),
                'data' => $data,
                'idempotency_key' => $idempotencyKey,
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Snippe Service Exception', [
                'message' => $e->getMessage(),
                'data' => $data
            ]);
            return null;
        }
    }

    /**
     * Verify webhook signature (if Snippe provides one, otherwise manual check)
     */
    public function verifyWebhook($payload, $signature = null)
    {
        // If no secret configured, we cannot verify.
        if (!$this->webhookSecret) {
            return true;
        }

        $timestamp = $payload['timestamp'] ?? null;
        $rawBody = $payload['raw_body'] ?? '';
        $signatureHeader = $signature;

        if (!$timestamp || !$signatureHeader) {
            return false;
        }

        // Optional replay protection: allow 10 minutes clock skew.
        if (is_numeric($timestamp)) {
            $diff = abs(time() - (int) $timestamp);
            if ($diff > 600) {
                return false;
            }
        }

        $signedPayload = $timestamp . '.' . $rawBody;
        $computed = hash_hmac('sha256', $signedPayload, $this->webhookSecret);

        return hash_equals($computed, (string) $signatureHeader);
    }
}
