<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\LectureProgress;
use App\Models\LectureVideo;
use App\Services\SiteContentService;
use App\Services\StudentMetricsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class StudentDashboardController extends Controller
{
    public function __construct(protected StudentMetricsService $metrics)
    {
    }

    /**
     * Build the student profile payload from the authenticated user only.
     */
    protected function getStudentData()
    {
        $user = Auth::user();

        if (! $user) {
            return null;
        }

        return [
            'id' => $user->id,
            'name' => $user->name ?: 'MDCAT Aspirant',
            'email' => $user->email,
            'phone' => $user->phone ?? '',
            'avatar' => $user->avatar ?: 'frontend/img/testimonial/testi_2_1.png',
            'target_exam' => strtoupper($user->target_exam ?? 'MDCAT'),
            'role' => $user->role ?? 'student',
            'joined_date' => !empty($user->created_at) ? $user->created_at->format('M Y') : now()->format('M Y'),
        ];
    }

    /**
     * 1. Student LMS Dashboard (Overview)
     */
    public function dashboard(Request $request)
    {
        $studentData = $this->getStudentData();
        if (!$studentData) {
            return redirect()->route('login', ['redirect' => route('student.dashboard')])
                ->with('warning', 'Please sign in to access your Student LMS Dashboard.');
        }

        $examDate = \Carbon\Carbon::create(2026, 8, 25);
        $daysRemaining = max(1, (int) now()->diffInDays($examDate, false));

        $courses = SiteContentService::getAllCourses();
        $activeCourse = reset($courses) ?: null;

        $stats = array_merge($this->metrics->stats($studentData['id']), [
            'enrolled_batches' => count($courses),
            'active_batch_name' => $activeCourse['title'] ?? 'No active batch yet',
        ]);

        $subjectReadiness = $this->metrics->subjectReadiness($studentData['id']);
        $recentTestHistory = $this->metrics->recentAttempts($studentData['id'], 3);

        $announcements = [
            [
                'title' => 'Live Strategy Session: How to Score 180+ in MDCAT 2026',
                'date' => 'Friday, 07 Nov • 7:00 PM',
                'badge' => 'Live Session',
            ],
            [
                'title' => 'NUMS 2026 Diagnostic Test Paper Uploaded to E-Library',
                'date' => '03 Nov 2026',
                'badge' => 'Resource',
            ],
        ];

        $tests = SiteContentService::getAllTests();
        $resources = SiteContentService::getAllResources();

        return view('student.dashboard', compact(
            'studentData',
            'daysRemaining',
            'stats',
            'subjectReadiness',
            'recentTestHistory',
            'announcements',
            'courses',
            'tests',
            'resources'
        ));
    }

    /**
     * 2. My Courses & Batches
     */
    public function courses(Request $request)
    {
        $studentData = $this->getStudentData();
        if (!$studentData) {
            return redirect()->route('login');
        }

        $courses = SiteContentService::getAllCourses();
        return view('student.courses', compact('studentData', 'courses'));
    }

    /**
     * 3. Classroom Video Player (Inside LMS Sidebar Layout)
     */
    public function classroom(Request $request, $slug = null)
    {
        $studentData = $this->getStudentData();
        if (!$studentData) {
            return redirect()->route('login');
        }

        $courses = SiteContentService::getAllCourses();
        $slug = $slug ?? $request->query('course') ?? array_key_first($courses);

        $activeCourse = $courses[$slug] ?? reset($courses);

        $lectureLibrary = [];
        $lectureProgressMap = [];

        try {
            if ($activeCourse && Schema::hasTable('lecture_videos')) {
                $lectureIds = $this->collectLectureIds($activeCourse['curriculum'] ?? $activeCourse['modules'] ?? []);
                $courseId = $activeCourse['id'] ?? null;

                if ($lectureIds || $courseId) {
                    $lectures = LectureVideo::query()
                        ->where(function ($query) use ($lectureIds, $courseId) {
                            if ($lectureIds) {
                                $query->whereIn('id', $lectureIds);
                            }
                            if ($courseId) {
                                $query->orWhere('course_id', $courseId);
                            }
                        })
                        ->get();

                    $lectureLibrary = $lectures->mapWithKeys(fn (LectureVideo $video) => [
                        $video->id => [
                            'id' => $video->id,
                            'title' => $video->title,
                            'status' => $video->status,
                            'progress' => (int) $video->progress,
                            'error' => $video->error_message,
                            'duration' => $video->duration_seconds,
                            'hls' => (bool) $video->hls_path,
                            'qualities' => array_keys($video->qualities ?: []),
                        ],
                    ])->all();

                    if (Schema::hasTable('lecture_progress')) {
                        $lectureProgressMap = LectureProgress::query()
                            ->where('user_id', $studentData['id'])
                            ->whereIn('lecture_video_id', $lectures->pluck('id'))
                            ->get()
                            ->mapWithKeys(fn (LectureProgress $progress) => [
                                $progress->lecture_video_id => [
                                    'position' => (int) $progress->position_seconds,
                                    'duration' => (int) $progress->duration_seconds,
                                    'percent' => (int) $progress->percent,
                                    'completed' => (bool) $progress->completed,
                                ],
                            ])
                            ->all();
                    }
                }
            }
        } catch (\Throwable $e) {
            // Lecture tables not migrated yet — keep the classroom usable.
            $lectureLibrary = [];
            $lectureProgressMap = [];
        }

        return view('student.classroom', compact(
            'studentData',
            'courses',
            'activeCourse',
            'lectureLibrary',
            'lectureProgressMap'
        ));
    }

    /**
     * Recursively collect lecture ids referenced inside a curriculum payload.
     */
    protected function collectLectureIds($data, array &$ids = []): array
    {
        if (is_string($data)) {
            $decoded = json_decode($data, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $this->collectLectureIds($decoded, $ids);
            }

            return array_keys($ids);
        }

        if (! is_array($data)) {
            return array_keys($ids);
        }

        foreach ($data as $key => $value) {
            if ($key === 'lectureId') {
                if (is_numeric($value) && (int) $value > 0) {
                    $ids[(int) $value] = true;
                }
                continue;
            }

            if (is_array($value) || is_string($value)) {
                $this->collectLectureIds($value, $ids);
            }
        }

        return array_keys($ids);
    }

    /**
     * 4. Mock Test Center
     */
    public function tests(Request $request)
    {
        $studentData = $this->getStudentData();
        if (!$studentData) {
            return redirect()->route('login');
        }

        $tests = SiteContentService::getAllTests();
        $categories = config('tests.categories', []);
        $stats = $this->metrics->stats($studentData['id']);
        $recentAttempts = $this->metrics->recentAttempts($studentData['id'], 10);

        return view('student.tests', compact('studentData', 'tests', 'categories', 'stats', 'recentAttempts'));
    }

    /**
     * 5. E-Library Vault
     */
    public function elibrary(Request $request)
    {
        $studentData = $this->getStudentData();
        if (!$studentData) {
            return redirect()->route('login');
        }

        $resources = SiteContentService::getAllResources();
        $categories = config('elibrary.categories', []);

        return view('student.elibrary', compact('studentData', 'resources', 'categories'));
    }

    /**
     * 6. Performance & Weak Area Analytics
     */
    public function analytics(Request $request)
    {
        $studentData = $this->getStudentData();
        if (!$studentData) {
            return redirect()->route('login');
        }

        $stats = $this->metrics->stats($studentData['id']);
        $subjectReadiness = $this->metrics->subjectReadiness($studentData['id']);
        $recentTestHistory = $this->metrics->recentAttempts($studentData['id'], 5);
        $actionPlan = $this->metrics->actionPlan($studentData['id']);

        return view('student.analytics', compact('studentData', 'stats', 'subjectReadiness', 'recentTestHistory', 'actionPlan'));
    }

    /**
     * 7. Account Settings & Profile
     */
    public function settings(Request $request)
    {
        $studentData = $this->getStudentData();
        if (!$studentData) {
            return redirect()->route('login');
        }

        return view('student.settings', compact('studentData'));
    }

    /**
     * Update Student Profile & Settings
     */
    public function updateSettings(Request $request)
    {
        $studentData = $this->getStudentData();
        if (!$studentData) {
            return redirect()->route('login');
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:25',
            'target_exam' => 'nullable|string|max:30',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user = Auth::user();
        if ($user) {
            $user->name = $request->name;
            $user->phone = $request->phone;
            if ($request->filled('target_exam')) {
                $user->target_exam = strtolower($request->target_exam);
            }
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
        }

        // Keep the display-only session cache in sync with the database user.
        if ($user) {
            session([
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'target_exam' => $user->target_exam ?? 'mdcat',
                    'avatar' => $user->avatar ?: 'frontend/img/testimonial/testi_2_1.png',
                    'role' => $user->role,
                    'enrolled_date' => $user->created_at ? $user->created_at->format('M Y') : now()->format('M Y'),
                ],
            ]);
        }

        return redirect()->route('student.settings')->with('success', 'Profile and preferences successfully updated!');
    }
}
