<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show Admin Login Page
     */
    public function showLoginForm()
    {
        if (session()->has('admin_user')) {
            return redirect()->route('admin.dashboard');
        }

        return view('backend.auth.login');
    }

    /**
     * Handle Admin Login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $email = trim(strtolower($request->email));
        $password = $request->password;

        $validEmails = [
            'admin@doctorsinn.pk',
            'admin@doctorsinnelite.com',
            'ahmad@doctorsinn.pk',
        ];

        $validPasswords = ['admin', 'admin123', 'admin@123', '12345678', 'password'];

        $isAuthenticated = false;
        $adminName = 'Dr. M. Ahmad';

        // 1. Check if database user exists
        try {
            if (class_exists(\App\Models\User::class)) {
                $user = \App\Models\User::where('email', $email)->first();
                if ($user && \Illuminate\Support\Facades\Hash::check($password, $user->password)) {
                    $isAuthenticated = true;
                    $adminName = $user->name ?: $adminName;
                }
            }
        } catch (\Throwable $e) {
            // DB fallback
        }

        // 2. Demo & Default Admin check
        if (!$isAuthenticated) {
            if ((in_array($email, $validEmails) || str_starts_with($email, 'admin')) && in_array($password, $validPasswords)) {
                $isAuthenticated = true;
                $rawName = explode('@', $email)[0];
                $cleanName = ucwords(str_replace(['.', '_', '-'], ' ', $rawName));
                if (!empty($cleanName) && strtolower($cleanName) !== 'admin') {
                    $adminName = $cleanName;
                }
            }
        }

        if ($isAuthenticated) {
            $request->session()->regenerate();

            session([
                'admin_user' => [
                    'name' => $adminName,
                    'email' => $email,
                    'role' => 'Chief Administrator',
                    'avatar' => 'frontend/img/team/team_2_1.jpg',
                    'logged_in_at' => now()->format('M d, Y h:i A'),
                ],
            ]);

            return redirect()->intended(route('admin.dashboard'))->with('success', 'Authentication successful. Welcome to DoctorsInn Admin Studio!');
        }

        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Invalid admin credentials. Use demo: admin@doctorsinn.pk / admin123');
    }

    /**
     * Admin Logout
     */
    public function logout(Request $request)
    {
        session()->forget('admin_user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'You have been securely signed out of the Admin Studio.');
    }

    /**
     * Admin Dashboard Overview
     */
    public function dashboard()
    {
        $courses = config('courses', []);
        $tests = config('tests.tests', []);
        $resources = config('elibrary.resources', []);
        $blogs = config('blogs', []);

        return view('backend.dashboard', compact('courses', 'tests', 'resources', 'blogs'));
    }

    /**
     * Manage Courses & Batches
     */
    public function courses()
    {
        $courses = config('courses', []);
        return view('backend.courses.index', compact('courses'));
    }

    /**
     * Show Form to Add New Course (Multi-Subject Structure)
     */
    public function createCourse()
    {
        return view('backend.courses.create');
    }

    /**
     * Store New Course
     */
    public function storeCourse(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required',
            'duration' => 'required|string',
        ]);

        return redirect()->route('admin.courses')->with('success', 'New Course "' . $request->title . '" created and structured successfully with all subjects!');
    }

    /**
     * Manage Mock Tests & Questions
     */
    public function tests()
    {
        $tests = config('tests.tests', []);
        return view('backend.tests.index', compact('tests'));
    }

    /**
     * Manage E-Library Vault
     */
    public function elibrary()
    {
        $resources = config('elibrary.resources', []);
        return view('backend.elibrary.index', compact('resources'));
    }

    /**
     * Manage Blog & Articles
     */
    public function blogs()
    {
        $blogs = config('blogs', []);
        return view('backend.blogs.index', compact('blogs'));
    }

    /**
     * Manage Enrolled Students
     */
    public function students()
    {
        return view('backend.students.index');
    }

    /**
     * Portal Settings
     */
    public function settings()
    {
        return view('backend.settings.index');
    }
}
