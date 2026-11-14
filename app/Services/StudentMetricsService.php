<?php

namespace App\Services;

use App\Models\LectureProgress;
use App\Models\LectureVideo;
use App\Models\Notification;
use App\Models\TestAttempt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class StudentMetricsService
{
    protected const SUBJECTS = [
        'biology' => ['name' => 'Biology', 'icon' => 'fa-solid fa-dna', 'color' => '#10b981'],
        'chemistry' => ['name' => 'Chemistry', 'icon' => 'fa-solid fa-flask-vial', 'color' => '#3b82f6'],
        'physics' => ['name' => 'Physics', 'icon' => 'fa-solid fa-atom', 'color' => '#f59e0b'],
        'english_logic' => ['name' => 'English & Logic', 'icon' => 'fa-solid fa-brain', 'color' => '#8b5cf6'],
    ];

    public function stats(int $userId): array
    {
        $hasAttempts = Schema::hasTable('test_attempts');
        $hasProgress = Schema::hasTable('lecture_progress');
        $hasLectures = Schema::hasTable('lecture_videos');

        $attemptQuery = $hasAttempts ? TestAttempt::where('user_id', $userId) : null;
        $progressQuery = $hasProgress ? LectureProgress::where('user_id', $userId) : null;

        $testsCompleted = $attemptQuery ? (clone $attemptQuery)->count() : 0;
        $avgScore = $attemptQuery ? round((float) ((clone $attemptQuery)->avg('percentage') ?? 0), 1) : 0.0;
        $highestScore = $attemptQuery ? round((float) ((clone $attemptQuery)->max('percentage') ?? 0), 1) : 0.0;

        $correct = $attemptQuery ? (int) (clone $attemptQuery)->sum('correct_count') : 0;
        $incorrect = $attemptQuery ? (int) (clone $attemptQuery)->sum('incorrect_count') : 0;
        $skipped = $attemptQuery ? (int) (clone $attemptQuery)->sum('skipped_count') : 0;
        $answered = $correct + $incorrect;

        $completedLectures = $progressQuery ? (clone $progressQuery)->where('completed', true)->count() : 0;
        $totalLectures = $hasLectures ? LectureVideo::where('status', 'ready')->count() : 0;
        $syllabus = $totalLectures > 0 ? (int) round(min(100, ($completedLectures / $totalLectures) * 100)) : 0;

        $watchedSeconds = $progressQuery ? (int) (clone $progressQuery)->sum('position_seconds') : 0;
        $testSeconds = $attemptQuery ? (int) (clone $attemptQuery)->sum('time_spent_seconds') : 0;

        return [
            'tests_completed' => $testsCompleted,
            'avg_score' => $avgScore,
            'highest_score' => $highestScore,
            'syllabus_completed' => $syllabus,
            'completed_lectures' => $completedLectures,
            'total_lectures' => $totalLectures,
            'study_streak_days' => $this->studyStreak($userId),
            'hours_studied' => round(($watchedSeconds + $testSeconds) / 3600, 1),
            'correct_mcqs' => $correct,
            'incorrect_mcqs' => $incorrect,
            'skipped_mcqs' => $skipped,
            'total_mcqs' => $correct + $incorrect + $skipped,
            'accuracy_rate' => $answered > 0 ? round(($correct / $answered) * 100, 1) : 0.0,
        ];
    }

    public function subjectReadiness(int $userId): array
    {
        $aggregate = [];

        if (Schema::hasTable('test_attempts')) {
            foreach (TestAttempt::where('user_id', $userId)->pluck('subject_stats') as $subjectStats) {
                foreach ((array) $subjectStats as $subjectName => $row) {
                    $bucket = $this->subjectBucket((string) $subjectName);
                    if (! $bucket) {
                        continue;
                    }

                    $aggregate[$bucket]['attempted'] = ($aggregate[$bucket]['attempted'] ?? 0) + (int) ($row['attempted'] ?? 0);
                    $aggregate[$bucket]['correct'] = ($aggregate[$bucket]['correct'] ?? 0) + (int) ($row['correct'] ?? 0);
                }
            }
        }

        $readiness = [];

        foreach (self::SUBJECTS as $key => $meta) {
            $attempted = (int) ($aggregate[$key]['attempted'] ?? 0);
            $correct = (int) ($aggregate[$key]['correct'] ?? 0);
            $percentage = $attempted > 0 ? (int) round(($correct / $attempted) * 100) : 0;

            $readiness[$key] = [
                'name' => $meta['name'],
                'icon' => $meta['icon'],
                'color' => $meta['color'],
                'percentage' => $percentage,
                'status' => $this->statusFor($attempted, $percentage),
                'weak_areas' => $attempted > 0 ? 'Review ' . ($attempted - $correct) . ' missed MCQs' : 'No attempts yet',
                'attempted' => $attempted,
                'correct' => $correct,
            ];
        }

        return $readiness;
    }

    public function recentAttempts(int $userId, int $limit = 5): array
    {
        if (! Schema::hasTable('test_attempts')) {
            return [];
        }

        return TestAttempt::where('user_id', $userId)
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get()
            ->map(fn (TestAttempt $attempt) => [
                'id' => $attempt->id,
                'title' => $attempt->test_title,
                'date' => $attempt->created_at?->format('d M Y') ?? '',
                'score' => (int) $attempt->score,
                'total' => (int) $attempt->total_marks,
                'percentage' => (int) round($attempt->percentage),
                'status' => $attempt->passed ? 'Passed' : 'Needs Review',
                'url' => route('test.result', $attempt->id),
            ])
            ->all();
    }

    public function actionPlan(int $userId): array
    {
        $readiness = $this->subjectReadiness($userId);

        uasort($readiness, function ($a, $b) {
            if ($a['attempted'] === 0 && $b['attempted'] !== 0) {
                return 1;
            }
            if ($b['attempted'] === 0 && $a['attempted'] !== 0) {
                return -1;
            }

            return $a['percentage'] <=> $b['percentage'];
        });

        $plan = [];

        foreach (array_slice($readiness, 0, 3, true) as $subject) {
            $hasData = $subject['attempted'] > 0;

            if (! $hasData) {
                $badge = 'Start Here';
                $badgeColor = 'warning';
                $recommendation = 'Attempt a ' . $subject['name'] . ' mock test so weak topics can be identified.';
            } elseif ($subject['percentage'] < 50) {
                $badge = 'High Priority';
                $badgeColor = 'danger';
                $recommendation = 'Re-watch ' . $subject['name'] . ' lectures and attempt 25 MCQs to rebuild accuracy.';
            } elseif ($subject['percentage'] < 70) {
                $badge = 'Moderate';
                $badgeColor = 'warning';
                $recommendation = 'Practice ' . ($subject['attempted'] - $subject['correct']) . ' missed ' . $subject['name'] . ' MCQs from the E-Library.';
            } else {
                $badge = 'Refinement';
                $badgeColor = 'success';
                $recommendation = 'Accuracy is ' . $subject['percentage'] . '% — keep revising with timed MCQs to hold full marks.';
            }

            $plan[] = [
                'subject' => $subject['name'],
                'topic' => $hasData ? 'Accuracy ' . $subject['percentage'] . '%' : 'No attempts yet',
                'recommendation' => $recommendation,
                'badge' => $badge,
                'badge_color' => $badgeColor,
            ];
        }

        return $plan;
    }

    public function unreadNotifications(int $userId): int
    {
        if (! Schema::hasTable('notifications')) {
            return 0;
        }

        return Notification::where('user_id', $userId)->whereNull('read_at')->count();
    }

    protected function studyStreak(int $userId): int
    {
        $dates = collect();

        if (Schema::hasTable('lecture_progress')) {
            $dates = $dates->merge(
                LectureProgress::where('user_id', $userId)
                    ->whereNotNull('last_watched_at')
                    ->pluck('last_watched_at')
                    ->map(fn ($value) => Carbon::parse($value)->toDateString())
            );
        }

        if (Schema::hasTable('test_attempts')) {
            $dates = $dates->merge(
                TestAttempt::where('user_id', $userId)
                    ->pluck('created_at')
                    ->map(fn ($value) => Carbon::parse($value)->toDateString())
            );
        }

        $activeDays = $dates->filter()->unique()->flip();
        $cursor = Carbon::today();

        if (! $activeDays->has($cursor->toDateString()) && $activeDays->has($cursor->copy()->subDay()->toDateString())) {
            $cursor->subDay();
        }

        $streak = 0;
        while ($activeDays->has($cursor->toDateString())) {
            $streak++;
            $cursor->subDay();
        }

        return $streak;
    }

    protected function subjectBucket(string $subject): ?string
    {
        $value = strtolower($subject);

        if (str_contains($value, 'bio')) {
            return 'biology';
        }
        if (str_contains($value, 'chem')) {
            return 'chemistry';
        }
        if (str_contains($value, 'phys')) {
            return 'physics';
        }
        if (str_contains($value, 'eng') || str_contains($value, 'logic') || str_contains($value, 'reason')) {
            return 'english_logic';
        }

        return null;
    }

    protected function statusFor(int $attempted, int $percentage): string
    {
        if ($attempted === 0) {
            return 'Not started';
        }

        return match (true) {
            $percentage >= 75 => 'Strong',
            $percentage >= 60 => 'Good',
            $percentage >= 40 => 'Needs Work',
            default => 'Weak',
        };
    }
}
