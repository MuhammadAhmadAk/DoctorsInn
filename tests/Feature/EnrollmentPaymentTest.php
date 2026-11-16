<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Order;
use App\Models\User;
use App\Services\EnrollmentService;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnrollmentPaymentTest extends TestCase
{
    use RefreshDatabase;

    protected function makeCourse(string $price = 'Rs. 5,000', string $slug = 'mdcat-crash'): Course
    {
        return Course::create(['slug' => $slug, 'title' => 'MDCAT Crash', 'price' => $price, 'is_active' => true]);
    }

    protected function makeOrder(User $user, Course $course, array $overrides = []): Order
    {
        return Order::create(array_merge([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'reference' => 'ORD-TEST' . Order::count(),
            'amount' => $course->priceInPaisa(),
            'currency' => 'PKR',
            'status' => Order::STATUS_PENDING,
            'gateway' => 'safepay',
            'gateway_tracker' => 'track_' . Order::count(),
        ], $overrides));
    }

    public function test_price_is_converted_to_paisa(): void
    {
        $this->assertSame(500000, $this->makeCourse('Rs. 5,000')->priceInPaisa());
        $this->assertSame(1200000, $this->makeCourse('Rs 12,000', 'c2')->priceInPaisa());
        $this->assertSame(250050, $this->makeCourse('PKR 2500.50', 'c3')->priceInPaisa());
        $this->assertTrue($this->makeCourse('Free', 'free-course')->isFree());
    }

    public function test_paid_tracker_marks_order_paid_and_enrolls_student(): void
    {
        $user = User::factory()->create(['role' => 'student']);
        $course = $this->makeCourse();
        $order = $this->makeOrder($user, $course);

        $paid = app(PaymentService::class)->applyTracker($order, ['state' => 'TRACKER_ENDED', 'amount' => $order->amount]);

        $this->assertTrue($paid);
        $this->assertSame(Order::STATUS_PAID, $order->fresh()->status);
        $this->assertNotNull($order->fresh()->paid_at);
        $this->assertTrue($user->fresh()->hasAccessToCourse($course->id));
        $this->assertSame('safepay', Enrollment::first()->source);
        $this->assertSame($order->id, Enrollment::first()->order_id);
    }

    public function test_repeated_paid_tracker_does_not_duplicate_enrollment(): void
    {
        $user = User::factory()->create(['role' => 'student']);
        $course = $this->makeCourse();
        $order = $this->makeOrder($user, $course);
        $payments = app(PaymentService::class);

        $payments->applyTracker($order, ['state' => 'TRACKER_ENDED', 'amount' => $order->amount]);
        $payments->applyTracker($order->fresh(), ['state' => 'TRACKER_ENDED', 'amount' => $order->amount]);

        $this->assertSame(1, Enrollment::count());
    }

    public function test_amount_mismatch_fails_order_without_access(): void
    {
        $user = User::factory()->create(['role' => 'student']);
        $course = $this->makeCourse();
        $order = $this->makeOrder($user, $course);

        $paid = app(PaymentService::class)->applyTracker($order, ['state' => 'TRACKER_ENDED', 'amount' => 100]);

        $this->assertFalse($paid);
        $this->assertSame(Order::STATUS_FAILED, $order->fresh()->status);
        $this->assertFalse($user->fresh()->hasAccessToCourse($course->id));
    }

    public function test_cancelled_and_expired_trackers_cancel_order(): void
    {
        $user = User::factory()->create(['role' => 'student']);
        $course = $this->makeCourse();
        $payments = app(PaymentService::class);

        foreach (['TRACKER_CANCELLED', 'TRACKER_EXPIRED'] as $state) {
            $order = $this->makeOrder($user, $course);
            $this->assertFalse($payments->applyTracker($order, ['state' => $state, 'amount' => null]));
            $this->assertSame(Order::STATUS_CANCELLED, $order->fresh()->status);
        }

        $this->assertSame(0, Enrollment::count());
    }

    public function test_mark_cancelled_leaves_paid_orders_untouched(): void
    {
        $user = User::factory()->create(['role' => 'student']);
        $course = $this->makeCourse();
        $order = $this->makeOrder($user, $course, ['status' => Order::STATUS_PAID]);

        app(PaymentService::class)->markCancelled($order);

        $this->assertSame(Order::STATUS_PAID, $order->fresh()->status);
    }

    public function test_revoke_removes_access_and_admin_always_has_access(): void
    {
        $user = User::factory()->create(['role' => 'student']);
        $admin = User::factory()->create(['role' => 'admin']);
        $course = $this->makeCourse();
        $service = app(EnrollmentService::class);

        $enrollment = $service->enroll($user, $course, 'manual');
        $this->assertTrue($service->userCanAccess($user, $course->id));

        $service->revoke($enrollment);
        $this->assertFalse($service->userCanAccess($user->fresh(), $course->id));
        $this->assertTrue($service->userCanAccess($admin, $course->id));
    }

    public function test_free_course_enrolls_and_shows_success_popup(): void
    {
        $user = User::factory()->create(['role' => 'student']);
        $course = $this->makeCourse('Free', 'free-course');

        $this->actingAs($user)
            ->post(route('courses.enroll', $course->slug))
            ->assertRedirect(route('student.dashboard'))
            ->assertSessionHas('enrollment_success');

        $this->assertTrue($user->fresh()->hasAccessToCourse($course->id));
    }

    public function test_paid_course_cannot_be_enrolled_for_free(): void
    {
        $user = User::factory()->create(['role' => 'student']);
        $course = $this->makeCourse();

        $this->actingAs($user)
            ->post(route('courses.enroll', $course->slug))
            ->assertRedirect(route('checkout', ['course' => $course->slug]));

        $this->assertSame(0, Enrollment::count());
    }

    public function test_webhook_rejects_forged_signature(): void
    {
        config(['services.safepay.webhook_secret' => 'test-webhook-secret']);

        $this->call('POST', route('webhooks.safepay'), [], [], [], [
            'HTTP_X-SFPY-SIGNATURE' => 'forged',
            'CONTENT_TYPE' => 'application/json',
        ], json_encode(['type' => 'payment.succeeded', 'data' => ['tracker' => 'x']]))
            ->assertStatus(400);
    }
}
