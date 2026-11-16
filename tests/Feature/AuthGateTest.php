<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthGateTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_sent_to_login_from_student_portal(): void
    {
        $location = $this->get('/student/dashboard')->assertRedirect()->headers->get('Location');

        $this->assertStringStartsWith(route('login'), $location);
    }

    public function test_guest_cannot_download_library_resource(): void
    {
        $this->get(route('e-library.download', 'any-book'))
            ->assertRedirect(route('login', ['redirect' => route('e-library.download', 'any-book')]));
    }

    public function test_guest_cannot_take_or_submit_tests(): void
    {
        $this->get(route('test.take', 'mdcat-1'))->assertRedirect();
        $this->assertStringContainsString('/login', $this->get(route('test.take', 'mdcat-1'))->headers->get('Location'));

        $this->post(route('test.submit', 'mdcat-1'))->assertRedirect();
    }

    public function test_student_without_enrollment_cannot_open_classroom(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $course = Course::create(['slug' => 'paid-course', 'title' => 'Paid Course', 'price' => 'Rs. 5,000', 'is_active' => true]);

        $response = $this->actingAs($student)->get(route('student.classroom', $course->slug));

        $this->assertNotEquals(200, $response->getStatusCode());
    }

    public function test_admin_panel_requires_staff_session(): void
    {
        $this->get('/admin/dashboard')->assertRedirect(route('admin.login'));
    }

    public function test_student_account_cannot_sign_into_admin_panel(): void
    {
        User::factory()->create([
            'email' => 'student@example.com',
            'role' => 'student',
            'password' => Hash::make('secret-pass'),
        ]);

        $this->post('/admin/login', ['email' => 'student@example.com', 'password' => 'secret-pass']);

        $this->assertFalse(session()->has('admin_user'));
    }

    public function test_admin_can_sign_in(): void
    {
        User::factory()->create([
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => Hash::make('secret-pass'),
        ]);

        $this->post('/admin/login', ['email' => 'admin@example.com', 'password' => 'secret-pass'])
            ->assertRedirect(route('admin.dashboard'));

        $this->assertSame('admin', session('admin_user.role_key'));
    }

    public function test_admin_login_is_throttled(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/admin/login', ['email' => 'nobody@example.com', 'password' => 'wrong']);
        }

        $this->post('/admin/login', ['email' => 'nobody@example.com', 'password' => 'wrong'])
            ->assertStatus(429);
    }

    public function test_disabled_staff_session_is_revoked(): void
    {
        $staff = User::factory()->create(['role' => 'staff', 'is_active' => false]);

        $this->withSession(['admin_user' => ['email' => $staff->email, 'role_key' => 'staff', 'permissions' => ['students']]])
            ->get('/admin/students')
            ->assertRedirect(route('admin.login'));
    }
}
