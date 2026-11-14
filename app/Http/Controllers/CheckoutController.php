<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Order;
use App\Services\EnrollmentService;
use App\Services\PaymentService;
use App\Services\SafepayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class CheckoutController extends Controller
{
    public function __construct(
        protected PaymentService $payments,
        protected EnrollmentService $enrollments,
        protected SafepayService $safepay
    ) {
    }

    /**
     * Enrollment checkout page for a course.
     */
    public function show(Request $request)
    {
        $course = $this->resolveCourse($request->query('course'));

        if (! $course) {
            return redirect()->route('course')->with('error', 'Please select a course to enroll in.');
        }

        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login', ['redirect' => $request->fullUrl()]);
        }

        if ($user->hasAccessToCourse($course->id)) {
            return redirect()->route('student.classroom', $course->slug)
                ->with('info', 'You already have access to this course.');
        }

        return view('frontend.pages.courses.checkout', [
            'course' => $course,
            'pendingOrder' => $this->payments->findOpenOrder($user, $course),
            'gatewayReady' => $this->safepay->isConfigured(),
        ]);
    }

    /**
     * Start a hosted Safepay checkout (EasyPaisa, JazzCash, card, bank).
     */
    public function pay(Request $request, string $slug)
    {
        $course = $this->resolveCourse($slug);

        if (! $course) {
            return redirect()->route('course')->with('error', 'That course is no longer available.');
        }

        $user = Auth::user();

        if ($user->hasAccessToCourse($course->id)) {
            return redirect()->route('student.classroom', $course->slug)
                ->with('info', 'You already have access to this course.');
        }

        if ($course->isFree()) {
            return $this->enrollFree($request, $slug);
        }

        if (! $this->safepay->isConfigured()) {
            return back()->with('error', 'Online payments are not configured yet. Please contact the academic desk.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:190',
            'phone' => 'required|string|max:30',
        ]);

        try {
            [$order, $checkoutUrl] = $this->payments->startCheckout($user, $course, $data);
        } catch (Throwable $e) {
            return back()->with('error', 'We could not start the payment. ' . $e->getMessage());
        }

        return redirect()->away($checkoutUrl);
    }

    /**
     * Free courses enroll immediately without a gateway.
     */
    public function enrollFree(Request $request, string $slug)
    {
        $course = $this->resolveCourse($slug);

        if (! $course) {
            return redirect()->route('course')->with('error', 'That course is no longer available.');
        }

        $user = Auth::user();

        if ($user->hasAccessToCourse($course->id)) {
            return redirect()->route('student.classroom', $course->slug);
        }

        if (! $course->isFree()) {
            return redirect()->route('checkout', ['course' => $course->slug]);
        }

        $this->enrollments->enroll($user, $course, 'free');

        return redirect()->route('student.classroom', $course->slug)
            ->with('success', 'Enrollment confirmed. Your classroom is ready.');
    }

    /**
     * Safepay redirects the student back here with ?tracker=...
     */
    public function callback(Request $request, string $reference)
    {
        $order = Order::query()
            ->where('reference', $reference)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $course = $order->course;
        $back = $course
            ? route('checkout', ['course' => $course->slug])
            : route('course');

        try {
            $status = $this->payments->refresh($order);
        } catch (Throwable $e) {
            Log::warning('Safepay callback verification failed', [
                'order' => $order->reference,
                'error' => $e->getMessage(),
            ]);

            return redirect($back)->with('warning', 'We could not confirm the payment yet. Please use "Verify payment" in a moment.');
        }

        $order->refresh();

        if ($order->isPaid() && $course) {
            return redirect()->route('student.classroom', $course->slug)
                ->with('success', 'Payment confirmed. Your enrollment is active.');
        }

        if ($status === Order::STATUS_CANCELLED) {
            return redirect($back)->with('error', 'The payment was cancelled or expired. No amount was charged.');
        }

        return redirect($back)->with('warning', 'Payment is still being confirmed by the bank. Please verify again in a moment.');
    }

    public function cancel(string $reference)
    {
        $order = Order::query()
            ->where('reference', $reference)
            ->where('user_id', Auth::id())
            ->first();

        $this->payments->markCancelled($order);

        if ($order?->course) {
            return redirect()->route('checkout', ['course' => $order->course->slug])
                ->with('info', 'Checkout was cancelled. You can try again any time.');
        }

        return redirect()->route('course')->with('info', 'Checkout was cancelled.');
    }

    /**
     * Re-check a pending payment without leaving the site.
     */
    public function status(string $reference)
    {
        $order = Order::query()
            ->where('reference', $reference)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        try {
            $this->payments->refresh($order);
        } catch (Throwable $e) {
            return back()->with('warning', 'Payment status could not be refreshed. Please try again.');
        }

        $order->refresh();

        if ($order->isPaid() && $order->course) {
            return redirect()->route('student.classroom', $order->course->slug)
                ->with('success', 'Payment confirmed. Your enrollment is active.');
        }

        return back()->with('warning', 'Safepay still shows this payment as pending. If you were charged, contact the academic desk with reference ' . $order->reference . '.');
    }

    protected function resolveCourse(?string $slug): ?Course
    {
        if (! $slug) {
            return null;
        }

        return Course::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->first();
    }
}
