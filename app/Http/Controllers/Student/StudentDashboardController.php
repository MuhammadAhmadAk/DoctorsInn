<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\SiteContentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentDashboardController extends Controller
{
    /**
     * Get or build student profile metadata
     */
    protected function getStudentData()
    {
        $user = Auth::user();
        $sessionUser = session('user');

        if (!$user && !$sessionUser) {
            return null;
        }

        return [
            'id' => $user->id ?? $sessionUser['id'] ?? 2,
            'name' => $user->name ?? $sessionUser['name'] ?? 'MDCAT Aspirant',
            'email' => $user->email ?? $sessionUser['email'] ?? 'student@doctorsinn.pk',
            'phone' => $user->phone ?? $sessionUser['phone'] ?? '+92 312 9876543',
            'avatar' => $user->avatar ?? $sessionUser['avatar'] ?? 'frontend/img/testimonial/testi_2_1.png',
            'target_exam' => strtoupper($user->target_exam ?? $sessionUser['target_exam'] ?? 'MDCAT'),
            'role' => $user->role ?? $sessionUser['role'] ?? 'student',
            'joined_date' => (!empty($user) && !empty($user->created_at)) ? $user->created_at->format('M Y') : (session('user.enrolled_date') ?? 'Nov 2026'),
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

        $stats = [
            'enrolled_batches' => 1,
            'active_batch_name' => 'MDCAT Reboot: 60-Day Prep Program',
            'tests_completed' => 6,
            'avg_score' => 78.5,
            'syllabus_completed' => 42,
            'study_streak_days' => 5,
            'hours_studied' => 28.5,
        ];

        $subjectReadiness = [
            'biology' => [
                'name' => 'Biology',
                'icon' => 'fa-solid fa-dna',
                'percentage' => 88,
                'status' => 'Strong',
                'color' => '#10b981',
                'weak_areas' => 'Genetics & Cell Respiration',
            ],
            'chemistry' => [
                'name' => 'Chemistry',
                'icon' => 'fa-solid fa-flask-vial',
                'percentage' => 74,
                'status' => 'Good',
                'color' => '#3b82f6',
                'weak_areas' => 'Organic Reaction Mechanisms',
            ],
            'physics' => [
                'name' => 'Physics',
                'icon' => 'fa-solid fa-atom',
                'percentage' => 61,
                'status' => 'Needs Work',
                'color' => '#f59e0b',
                'weak_areas' => 'Rotational Motion & Electromagnetism',
            ],
            'english_logic' => [
                'name' => 'English & Logic',
                'icon' => 'fa-solid fa-brain',
                'percentage' => 84,
                'status' => 'Strong',
                'color' => '#8b5cf6',
                'weak_areas' => 'Critical Vocabulary Synonyms',
            ],
        ];

        $recentTestHistory = [
            [
                'title' => 'MDCAT Grand Mock Test 1 — Full Syllabus',
                'date' => '04 Nov 2026',
                'score' => 162,
                'total' => 200,
                'percentage' => 81,
                'status' => 'Passed',
            ],
            [
                'title' => 'Biology High-Yield Unit Test: Cell Biology',
                'date' => '01 Nov 2026',
                'score' => 45,
                'total' => 50,
                'percentage' => 90,
                'status' => 'Passed',
            ],
            [
                'title' => 'Physics Mechanics & Dynamics Quiz',
                'date' => '28 Oct 2026',
                'score' => 31,
                'total' => 50,
                'percentage' => 62,
                'status' => 'Needs Review',
            ],
        ];

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

        $courses = SiteContentService::getAllCourses();
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

        return view('student.classroom', compact('studentData', 'courses', 'activeCourse'));
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

        return view('student.tests', compact('studentData', 'tests', 'categories'));
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

        $stats = [
            'tests_completed' => 6,
            'avg_score' => 78.5,
            'syllabus_completed' => 42,
            'study_streak_days' => 5,
            'hours_studied' => 28.5,
            'correct_mcqs' => 482,
            'incorrect_mcqs' => 118,
            'accuracy_rate' => 80.3,
        ];

        $subjectReadiness = [
            'biology' => [
                'name' => 'Biology',
                'icon' => 'fa-solid fa-dna',
                'percentage' => 88,
                'status' => 'Strong',
                'color' => '#10b981',
                'weak_areas' => 'Genetics & Cell Respiration',
                'attempted' => 260,
                'correct' => 229,
            ],
            'chemistry' => [
                'name' => 'Chemistry',
                'icon' => 'fa-solid fa-flask-vial',
                'percentage' => 74,
                'status' => 'Good',
                'color' => '#3b82f6',
                'weak_areas' => 'Organic Reaction Mechanisms',
                'attempted' => 180,
                'correct' => 133,
            ],
            'physics' => [
                'name' => 'Physics',
                'icon' => 'fa-solid fa-atom',
                'percentage' => 61,
                'status' => 'Needs Work',
                'color' => '#f59e0b',
                'weak_areas' => 'Rotational Motion & Electromagnetism',
                'attempted' => 110,
                'correct' => 67,
            ],
            'english_logic' => [
                'name' => 'English & Logic',
                'icon' => 'fa-solid fa-brain',
                'percentage' => 84,
                'status' => 'Strong',
                'color' => '#8b5cf6',
                'weak_areas' => 'Critical Vocabulary Synonyms',
                'attempted' => 50,
                'correct' => 42,
            ],
        ];

        $recentTestHistory = [
            [
                'title' => 'MDCAT Grand Mock Test 1 — Full Syllabus',
                'date' => '04 Nov 2026',
                'score' => 162,
                'total' => 200,
                'percentage' => 81,
                'status' => 'Passed',
            ],
            [
                'title' => 'Biology High-Yield Unit Test: Cell Biology',
                'date' => '01 Nov 2026',
                'score' => 45,
                'total' => 50,
                'percentage' => 90,
                'status' => 'Passed',
            ],
            [
                'title' => 'Physics Mechanics & Dynamics Quiz',
                'date' => '28 Oct 2026',
                'score' => 31,
                'total' => 50,
                'percentage' => 62,
                'status' => 'Needs Review',
            ],
        ];

        $actionPlan = [
            [
                'subject' => 'Physics',
                'topic' => 'Electromagnetism & Induced EMF Formulas',
                'recommendation' => 'Re-watch Lecture #4 and attempt 25 chapter MCQs in Mock Test Center.',
                'badge' => 'High Priority',
                'badge_color' => 'danger',
            ],
            [
                'subject' => 'Chemistry',
                'topic' => 'Organic Substitution vs Elimination Kinetics',
                'recommendation' => 'Download Chemistry Reaction Mechanism Flashcards from E-Library.',
                'badge' => 'Moderate',
                'badge_color' => 'warning',
            ],
            [
                'subject' => 'Biology',
                'topic' => 'Mendelian Crosses & Sex-Linked Pedigrees',
                'recommendation' => 'Solid foundation! Complete Genetics practice quiz to secure full marks.',
                'badge' => 'Refinement',
                'badge_color' => 'success',
            ],
        ];

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

        // Also update session
        $currentSession = session('user', []);
        $currentSession['name'] = $request->name;
        $currentSession['phone'] = $request->phone;
        if ($request->filled('target_exam')) {
            $currentSession['target_exam'] = strtolower($request->target_exam);
        }
        session(['user' => $currentSession]);

        return redirect()->route('student.settings')->with('success', 'Profile and preferences successfully updated!');
    }
}
