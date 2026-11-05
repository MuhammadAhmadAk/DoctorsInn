<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    /**
     * Show Pro-Level Student LMS Portal & Dashboard
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $sessionUser = session('user');

        if (!$user && !$sessionUser) {
            return redirect()->route('login', ['redirect' => route('student.dashboard')])
                ->with('warning', 'Please sign in to access your Student LMS Dashboard.');
        }

        // Student Profile Data
        $studentData = [
            'name' => $user->name ?? $sessionUser['name'] ?? 'MDCAT Aspirant',
            'email' => $user->email ?? $sessionUser['email'] ?? 'student@doctorsinn.pk',
            'phone' => $user->phone ?? $sessionUser['phone'] ?? '+92 312 9876543',
            'avatar' => $user->avatar ?? $sessionUser['avatar'] ?? 'frontend/img/testimonial/testi_2_1.png',
            'target_exam' => strtoupper($user->target_exam ?? $sessionUser['target_exam'] ?? 'MDCAT'),
            'role' => $user->role ?? $sessionUser['role'] ?? 'student',
            'joined_date' => $user->created_at ? $user->created_at->format('M Y') : (session('user.enrolled_date') ?? 'Nov 2026'),
        ];

        // Academic Countdown to MDCAT (approx August 2026)
        $examDate = \Carbon\Carbon::create(2026, 8, 25);
        $daysRemaining = max(1, (int) now()->diffInDays($examDate, false));

        // LMS KPI Performance Statistics
        $stats = [
            'enrolled_batches' => 1,
            'active_batch_name' => 'MDCAT Reboot: 60-Day Prep Program',
            'tests_completed' => 6,
            'avg_score' => 78.5,
            'syllabus_completed' => 42,
            'study_streak_days' => 5,
            'hours_studied' => 28.5,
        ];

        // Subject Readiness Diagnosis
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

        // Recent Test History
        $recentTestHistory = [
            [
                'title' => 'MDCAT Grand Mock Test 1 — Full Syllabus',
                'date' => '04 Nov 2026',
                'score' => 162,
                'total' => 200,
                'percentage' => 81,
                'status' => 'Passed',
                'time_taken' => '135 mins',
            ],
            [
                'title' => 'Biology High-Yield Unit Test: Cell Biology',
                'date' => '01 Nov 2026',
                'score' => 45,
                'total' => 50,
                'percentage' => 90,
                'status' => 'Passed',
                'time_taken' => '38 mins',
            ],
            [
                'title' => 'Physics Mechanics & Dynamics Quiz',
                'date' => '28 Oct 2026',
                'score' => 31,
                'total' => 50,
                'percentage' => 62,
                'status' => 'Needs Review',
                'time_taken' => '42 mins',
            ],
        ];

        // Academy Announcements
        $announcements = [
            [
                'title' => 'Live Strategy Session: How to Score 180+ in MDCAT 2026',
                'date' => 'Friday, 07 Nov • 7:00 PM',
                'badge' => 'Live Session',
                'type' => 'important',
            ],
            [
                'title' => 'NUMS 2026 Diagnostic Test Paper Uploaded to E-Library',
                'date' => '03 Nov 2026',
                'badge' => 'Resource',
                'type' => 'info',
            ],
        ];

        // Content Collections
        $courses = config('courses', []);
        $tests = config('tests.tests', []);
        $resources = config('elibrary.resources', []);

        return view('frontend.pages.student.dashboard', compact(
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
}
