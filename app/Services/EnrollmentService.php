<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Notification;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class EnrollmentService
{
    /**
     * Create or reactivate a student's access to a course.
     */
    public function enroll(
        User $user,
        Course $course,
        string $source = 'manual',
        ?Order $order = null,
        ?string $notes = null
    ): Enrollment {
        $enrollment = Enrollment::firstOrNew([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);

        $wasActive = $enrollment->exists && $enrollment->isActive();

        $enrollment->fill([
            'status' => Enrollment::STATUS_ACTIVE,
            'source' => $source,
            'order_id' => $order?->id ?? $enrollment->order_id,
            'notes' => $notes ?: $enrollment->notes,
            'expires_at' => null,
        ]);

        if ($enrollment->enrolled_at === null || ! $wasActive) {
            $enrollment->enrolled_at = now();
        }

        $enrollment->save();

        $this->forgetAccessCache($user->id, $course->id);

        if (! $wasActive) {
            Notification::create([
                'user_id' => $user->id,
                'type' => 'course',
                'title' => 'Course access activated',
                'message' => 'You are now enrolled in "' . $course->title . '". Open your classroom to start learning.',
                'url' => route('student.classroom', $course->slug),
            ]);
        }

        return $enrollment;
    }

    public function revoke(Enrollment $enrollment): void
    {
        $enrollment->update(['status' => Enrollment::STATUS_REVOKED]);

        $this->forgetAccessCache($enrollment->user_id, $enrollment->course_id);

        Notification::create([
            'user_id' => $enrollment->user_id,
            'type' => 'course',
            'title' => 'Course access updated',
            'message' => 'Your access to a course has been paused. Contact the academic desk if you need it restored.',
        ]);
    }

    public function userCanAccess(User $user, ?int $courseId): bool
    {
        if (! $courseId) {
            return true;
        }

        if ($user->role === 'admin') {
            return true;
        }

        return $user->enrollments()->active()->where('course_id', $courseId)->exists();
    }

    protected function forgetAccessCache(int $userId, int $courseId): void
    {
        Cache::forget('lecture-access:' . $userId . ':' . $courseId);
    }
}
