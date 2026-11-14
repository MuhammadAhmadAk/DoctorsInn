<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Lectures used to be open to every signed-in student. Preserve that
     * access as real enrollments so gating does not lock existing students out.
     */
    public function up(): void
    {
        $userIds = DB::table('users')->where('role', 'student')->pluck('id');
        $courseIds = DB::table('courses')->where('is_active', true)->pluck('id');

        if ($userIds->isEmpty() || $courseIds->isEmpty()) {
            return;
        }

        $now = now();
        $rows = [];

        foreach ($userIds as $userId) {
            foreach ($courseIds as $courseId) {
                $rows[] = [
                    'user_id' => $userId,
                    'course_id' => $courseId,
                    'status' => 'active',
                    'source' => 'manual',
                    'enrolled_at' => $now,
                    'notes' => 'Migrated from open access',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        foreach (array_chunk($rows, 500) as $chunk) {
            DB::table('enrollments')->insertOrIgnore($chunk);
        }
    }

    public function down(): void
    {
        DB::table('enrollments')
            ->where('notes', 'Migrated from open access')
            ->delete();
    }
};
