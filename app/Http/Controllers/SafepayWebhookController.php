<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\PaymentService;
use App\Services\SafepayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SafepayWebhookController extends Controller
{
    public function handle(Request $request, SafepayService $safepay, PaymentService $payments)
    {
        $raw = $request->getContent();

        if (! $safepay->verifyWebhook($raw, $request->header('X-SFPY-SIGNATURE'))) {
            return response('Invalid signature', 400);
        }

        $payload = json_decode($raw, true) ?: [];
        $eventType = $payload['type'] ?? $payload['event'] ?? 'unknown';
        $data = $payload['data'] ?? [];

        if (! in_array($eventType, ['payment.succeeded', 'payment.failed', 'payment.cancelled'], true)) {
            return response('Ok', 200);
        }

        $tracker = data_get($data, 'tracker.token') ?? data_get($data, 'tracker');
        $reference = data_get($data, 'metadata.order_id.value') ?? data_get($data, 'metadata.order_id');

        if (! is_string($tracker)) {
            $tracker = null;
        }

        if (! is_string($reference)) {
            $reference = null;
        }

        $order = Order::query()
            ->when($tracker, fn ($q) => $q->where('gateway_tracker', $tracker))
            ->when(! $tracker && $reference, fn ($q) => $q->where('reference', $reference))
            ->first();

        if (! $order) {
            Log::info('Safepay webhook received for an unknown order', [
                'event' => $eventType,
                'tracker' => $tracker,
                'reference' => $reference,
            ]);

            return response('Ok', 200);
        }

        // Always confirm with the reporter API instead of trusting the payload.
        try {
            $payments->refresh($order);
        } catch (\Throwable $e) {
            Log::warning('Safepay webhook verification failed', [
                'order' => $order->reference,
                'error' => $e->getMessage(),
            ]);
        }

        return response('Ok', 200);
    }
}
