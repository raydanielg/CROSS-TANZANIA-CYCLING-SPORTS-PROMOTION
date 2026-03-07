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
            if (!$this->apiKey) {
                Log::error('Snippe Payment Creation Failed: Missing API Key', [
                    'data' => $data,
                ]);

                return [
                    'error' => 'Missing Snippe API key',
                ];
            }

            $idempotencyKey = $data['idempotency_key'] ?? ('payment-' . Str::uuid()->toString());
            $baseUrl = rtrim($this->baseUrl, '/');

            $fullName = trim((string)($data['customer_name'] ?? ''));
            $parts = preg_split('/\s+/', $fullName, -1, PREG_SPLIT_NO_EMPTY) ?: [];
            $firstName = $parts[0] ?? $fullName;
            $lastName = count($parts) > 1 ? implode(' ', array_slice($parts, 1)) : '-';

            $paymentType = $data['payment_type'] ?? 'card';
            if (!in_array($paymentType, ['mobile', 'card', 'dynamic-qr'], true)) {
                $paymentType = 'card';
            }

            $rawPhone = (string)($data['customer_phone'] ?? '');
            $phoneNumber = preg_replace('/\D+/', '', $rawPhone) ?: $rawPhone;

            $details = [
                'amount' => (int) $data['amount'],
                'currency' => $data['currency'] ?? 'TZS',
            ];

            if ($paymentType === 'card') {
                if (!empty($data['redirect_url'])) {
                    $details['redirect_url'] = $data['redirect_url'];
                }
                if (!empty($data['cancel_url'])) {
                    $details['cancel_url'] = $data['cancel_url'];
                }
            }

            $customer = [
                'firstname' => $firstName,
                'lastname' => $lastName,
                'email' => $data['customer_email'],
            ];

            if ($paymentType === 'card') {
                $customer['address'] = $data['customer_address'] ?? 'N/A';
                $customer['city'] = $data['customer_city'] ?? 'Dar es Salaam';
                $customer['state'] = $data['customer_state'] ?? 'DSM';
                $customer['postcode'] = $data['customer_postcode'] ?? '00000';
                $customer['country'] = $data['customer_country'] ?? 'TZ';
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'Idempotency-Key' => $idempotencyKey,
            ])->post($baseUrl . '/v1/payments', [
                'payment_type' => $paymentType,
                'details' => $details,
                'phone_number' => $phoneNumber,
                'customer' => $customer,
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
                    'http_status' => $response->status(),
                ];
            }

            Log::error('Snippe Payment Creation Failed', [
                'status' => $response->status(),
                'body' => $response->body(),
                'data' => $data,
                'idempotency_key' => $idempotencyKey,
            ]);

            return [
                'error' => 'Snippe request failed',
                'http_status' => $response->status(),
                'body' => $response->body(),
            ];
        } catch (\Exception $e) {
            Log::error('Snippe Service Exception', [
                'message' => $e->getMessage(),
                'data' => $data
            ]);

            return [
                'error' => 'Snippe service exception',
                'exception' => $e->getMessage(),
            ];
        }
    }

    /**
     * Create a hosted checkout session with Snippe
     */
    public function createSession(array $data)
    {
        try {
            if (!$this->apiKey) {
                Log::error('Snippe Session Creation Failed: Missing API Key', [
                    'data' => $data,
                ]);

                return [
                    'error' => 'Missing Snippe API key',
                ];
            }

            $idempotencyKey = $data['idempotency_key'] ?? ('session-' . Str::uuid()->toString());
            $baseUrl = rtrim($this->baseUrl, '/');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'Idempotency-Key' => $idempotencyKey,
            ])->post($baseUrl . '/api/v1/sessions', [
                'profile_id' => $data['profile_id'] ?? null,
                'amount' => (int) $data['amount'],
                'currency' => $data['currency'] ?? 'TZS',
                'allowed_methods' => $data['allowed_methods'] ?? ['mobile_money', 'qr', 'card'],
                'customer' => [
                    'name' => $data['customer_name'] ?? null,
                    'phone' => $data['customer_phone'] ?? null,
                    'email' => $data['customer_email'] ?? null,
                ],
                'redirect_url' => $data['redirect_url'] ?? null,
                'webhook_url' => $data['webhook_url'] ?? null,
                'description' => $data['description'] ?? null,
                'metadata' => $data['metadata'] ?? [],
                'expires_in' => $data['expires_in'] ?? 3600,
            ]);

            if ($response->successful()) {
                $json = $response->json();
                $dataPayload = $json['data'] ?? [];

                return [
                    'raw' => $json,
                    'reference' => $dataPayload['reference'] ?? null,
                    'checkout_url' => $dataPayload['checkout_url'] ?? null,
                    'payment_link_url' => $dataPayload['payment_link_url'] ?? null,
                    'status' => $dataPayload['status'] ?? null,
                ];
            }

            Log::error('Snippe Session Creation Failed', [
                'status' => $response->status(),
                'body' => $response->body(),
                'data' => $data,
                'idempotency_key' => $idempotencyKey,
            ]);

            return [
                'error' => 'Snippe session request failed',
                'http_status' => $response->status(),
                'body' => $response->body(),
            ];
        } catch (\Exception $e) {
            Log::error('Snippe Session Service Exception', [
                'message' => $e->getMessage(),
                'data' => $data,
            ]);

            return [
                'error' => 'Snippe session service exception',
                'exception' => $e->getMessage(),
            ];
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
