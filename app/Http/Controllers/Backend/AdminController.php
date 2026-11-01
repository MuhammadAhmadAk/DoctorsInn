<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
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
