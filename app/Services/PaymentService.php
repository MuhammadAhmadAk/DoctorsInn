<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class PaymentService
{
    public function __construct(
        protected SafepayService $safepay,
        protected EnrollmentService $enrollments
    ) {
    }

    /**
     * Create a local order, a Safepay payment session and return the hosted
     * checkout URL the student must be redirected to.
     *
     * @return array{0: Order, 1: string}
     */
    public function startCheckout(User $user, Course $course, array $payer = []): array
    {
        $order = Order::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'reference' => $this->nextReference(),
            'amount' => $course->priceInPaisa(),
            'currency' => 'PKR',
            'status' => Order::STATUS_PENDING,
            'gateway' => 'safepay',
            'payer_name' => $payer['name'] ?? $user->name,
            'payer_email' => $payer['email'] ?? $user->email,
            'payer_phone' => $payer['phone'] ?? $user->phone,
        ]);

        try {
            $tracker = $this->safepay->createTracker($order->amount, $order->reference);

            $tbt = $this->safepay->createPassport();

            $order->update([
                'gateway_tracker' => $tracker['tracker'],
                'gateway_state' => $tracker['state'],
            ]);

            $url = $this->safepay->checkoutUrl(
                $tracker['tracker'],
                $tbt,
                route('checkout.callback', ['reference' => $order->reference]),
                route('checkout.cancel', ['reference' => $order->reference])
            );

            return [$order, $url];
        } catch (Throwable $e) {
            $order->update([
                'status' => Order::STATUS_FAILED,
                'failure_reason' => Str::limit($e->getMessage(), 250),
            ]);

            Log::warning('Safepay checkout could not be started', [
                'order' => $order->reference,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Ask Safepay for the authoritative status and apply it locally.
     */
    public function refresh(Order $order): string
    {
        if ($order->isPaid()) {
            return Order::STATUS_PAID;
        }

        if (! $order->gateway_tracker) {
            return $order->status;
        }

        $tracker = $this->safepay->fetchTracker($order->gateway_tracker);

        return $this->applyTracker($order, $tracker);
    }

    /**
     * @return bool true when the order is paid
     */
    public function applyTracker(Order $order, array $tracker): bool
    {
        $state = $tracker['state'] ?? null;
        $order->gateway_state = $state;

        if ($state === 'TRACKER_ENDED') {
            if ($tracker['amount'] !== null && (int) $tracker['amount'] !== (int) $order->amount) {
                $order->status = Order::STATUS_FAILED;
                $order->failure_reason = 'Paid amount did not match the order amount.';
                $order->save();

                Log::warning('Safepay amount mismatch', [
                    'order' => $order->reference,
                    'expected' => $order->amount,
                    'received' => $tracker['amount'],
                ]);

                return false;
            }

            if (! $order->isPaid()) {
                $order->status = Order::STATUS_PAID;
                $order->paid_at = now();
                $order->failure_reason = null;
                $order->save();

                if ($order->user && $order->course) {
                    $this->enrollments->enroll($order->user, $order->course, 'safepay', $order);
                }
            }

            return true;
        }

        if (in_array($state, ['TRACKER_CANCELLED', 'TRACKER_EXPIRED'], true)) {
            $order->status = Order::STATUS_CANCELLED;
            $order->save();
        }

        return false;
    }

    public function markCancelled(?Order $order): void
    {
        if ($order && $order->status === Order::STATUS_PENDING) {
            $order->update(['status' => Order::STATUS_CANCELLED]);
        }
    }

    public function findOpenOrder(User $user, Course $course): ?Order
    {
        return Order::query()
            ->where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('status', Order::STATUS_PENDING)
            ->where('created_at', '>=', now()->subHours(2))
            ->latest()
            ->first();
    }

    public function latestEnrollmentSource(User $user, Course $course): ?Enrollment
    {
        return Enrollment::query()
            ->where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->latest()
            ->first();
    }

    protected function nextReference(): string
    {
        do {
            $reference = 'ORD-' . strtoupper(Str::random(10));
        } while (Order::where('reference', $reference)->exists());

        return $reference;
    }
}
