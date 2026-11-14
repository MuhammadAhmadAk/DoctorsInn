<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class SafepayService
{
    protected const SANDBOX_API = 'https://sandbox.api.getsafepay.com';
    protected const PRODUCTION_API = 'https://api.getsafepay.com';

    protected const SANDBOX_CHECKOUT = 'https://sandbox.api.getsafepay.com/embedded/';
    protected const PRODUCTION_CHECKOUT = 'https://getsafepay.com/embedded/';

    public function isConfigured(): bool
    {
        return filled(config('services.safepay.public_key'))
            && filled(config('services.safepay.secret_key'));
    }

    public function environment(): string
    {
        return config('services.safepay.environment', 'sandbox') === 'production'
            ? 'production'
            : 'sandbox';
    }

    /**
     * Create a payment tracker (payment session) and return its data.
     *
     * @return array{tracker: string, state: ?string, raw: array}
     */
    public function createTracker(int $amountPaisa, string $reference): array
    {
        $this->ensureConfigured();

        $payload = [
            'merchant_api_key' => (string) config('services.safepay.public_key'),
            'intent' => (string) config('services.safepay.intent', 'CYBERSOURCE'),
            'mode' => 'payment',
            'entry_mode' => 'raw',
            'currency' => 'PKR',
            'amount' => $amountPaisa,
            'metadata' => ['order_id' => $reference],
            'include_fees' => false,
        ];

        $data = $this->request('post', '/order/payments/v3/', $payload);

        $tracker = data_get($data, 'tracker.token');

        if (! is_string($tracker) || $tracker === '') {
            throw new RuntimeException('Safepay did not return a tracker token.');
        }

        return [
            'tracker' => $tracker,
            'state' => data_get($data, 'tracker.state'),
            'raw' => $data,
        ];
    }

    /**
     * Short-lived authentication token used to open the hosted checkout page.
     */
    public function createPassport(): string
    {
        $this->ensureConfigured();

        $data = $this->request('post', '/client/passport/v1/token');

        $token = is_string($data) ? $data : data_get($data, 'token');

        if (! is_string($token) || $token === '') {
            throw new RuntimeException('Safepay did not return an authentication token.');
        }

        return $token;
    }

    public function checkoutUrl(string $tracker, string $tbt, string $successUrl, string $cancelUrl): string
    {
        $base = $this->environment() === 'production'
            ? self::PRODUCTION_CHECKOUT
            : self::SANDBOX_CHECKOUT;

        $query = http_build_query([
            'environment' => $this->environment(),
            'tracker' => $tracker,
            'tbt' => $tbt,
            'source' => 'hosted',
            'redirect_url' => $successUrl,
            'cancel_url' => $cancelUrl,
        ]);

        return $base . '?' . $query;
    }

    /**
     * Fetch a tracker from Safepay. This is the authoritative payment result.
     *
     * @return array{state: ?string, amount: ?int, currency: ?string, raw: array}
     */
    public function fetchTracker(string $tracker): array
    {
        $this->ensureConfigured();

        $data = $this->request('get', '/reporter/api/v1/payments/' . rawurlencode($tracker));

        $trackerData = data_get($data, 'tracker') ?: $data;

        return [
            'state' => data_get($trackerData, 'state'),
            'amount' => data_get($data, 'purchase_totals.quote_amount.amount')
                ?? data_get($data, 'purchase_totals.base_amount.amount'),
            'currency' => data_get($data, 'purchase_totals.quote_amount.currency'),
            'raw' => $data,
        ];
    }

    public function verifyWebhook(string $rawBody, ?string $signature): bool
    {
        $secret = (string) config('services.safepay.webhook_secret');

        if ($secret === '' || ! is_string($signature) || $signature === '') {
            return false;
        }

        $payload = json_decode($rawBody, true);

        if (! is_array($payload) || ! isset($payload['data'])) {
            return false;
        }

        $expected = hash_hmac('sha512', json_encode($payload['data'], JSON_UNESCAPED_SLASHES), $secret);

        return hash_equals($expected, $signature);
    }

    protected function request(string $method, string $path, array $payload = []): mixed
    {
        $url = $this->apiBase() . $path;

        $client = Http::withHeaders([
            'X-SFPY-MERCHANT-SECRET' => (string) config('services.safepay.secret_key'),
        ])->acceptJson()->timeout(25);

        $response = $method === 'get'
            ? $client->get($url)
            : $client->post($url, $payload);

        $body = $response->json();

        if ($response->failed()) {
            $errors = data_get($body, 'status.errors');
            $message = is_array($errors) && $errors
                ? implode(', ', $errors)
                : 'Safepay request failed with HTTP ' . $response->status() . '.';

            throw new RuntimeException($message);
        }

        if (! is_array($body) || ($body['status']['errors'] ?? []) !== []) {
            $errors = is_array($body) ? ($body['status']['errors'] ?? []) : [];
            throw new RuntimeException($errors ? implode(', ', $errors) : 'Unexpected response from Safepay.');
        }

        return $body['data'] ?? null;
    }

    protected function apiBase(): string
    {
        return $this->environment() === 'production'
            ? self::PRODUCTION_API
            : self::SANDBOX_API;
    }

    protected function ensureConfigured(): void
    {
        if (! $this->isConfigured()) {
            throw new RuntimeException('Safepay is not configured. Add the sandbox or live API keys to the environment.');
        }
    }
}
