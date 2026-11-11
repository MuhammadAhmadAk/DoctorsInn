<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Course;
use App\Models\ElibraryResource;
use App\Models\MockTest;
use App\Models\SiteContent;
use App\Services\SiteContentService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        $courses = SiteContentService::getAllCourses();
        $tests = SiteContentService::getAllTests();
        $resources = SiteContentService::getAllResources();
        $blogs = SiteContentService::getAllBlogs();

        return view('backend.dashboard', compact('courses', 'tests', 'resources', 'blogs'));
    }

    /**
     * Manage Courses & Batches
     */
    public function courses()
    {
        $courses = SiteContentService::getAllCourses();
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
     * Store or Update Course (Persisted to DB + Cache Flushed)
     */
    public function storeCourse(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required',
            'duration' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $slug = $request->input('slug') ?: Str::slug($request->title);
        $catMap = ['mdcat' => 'MDCAT', 'nums' => 'NUMS', 'army' => 'Army / AMC'];
        $category = strtolower($request->category);

        $imagePath = $request->input('existing_image');
        if ($request->hasFile('thumbnail')) {
            $imagePath = SiteContentService::uploadImage($request->file('thumbnail'), 'courses');
        }

        Course::updateOrCreate(
            ['slug' => $slug],
            [
                'title' => $request->title,
                'category' => $category,
                'category_name' => $catMap[$category] ?? strtoupper($category),
                'price' => $request->price,
                'original_price' => $request->input('original_price'),
                'duration' => $request->duration,
                'lessons' => $request->input('lessons', '40+ Lectures'),
                'students' => $request->input('students', '500+ Students'),
                'instructor' => $request->input('instructor', 'DoctorsInn Faculty'),
                'overview' => $request->input('overview', 'Structured medical entry test preparation batch.'),
                'image' => $imagePath ?: 'frontend/img/course/course1-1.jpg',
                'detail_image' => $imagePath ?: 'frontend/img/course/course1-1.jpg',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        return redirect()->route('admin.courses')->with('success', 'Course "' . $request->title . '" saved and published live!');
    }

    public function deleteCourse($slug)
    {
        Course::where('slug', $slug)->delete();
        return redirect()->route('admin.courses')->with('success', 'Course removed from catalog.');
    }

    /**
     * Manage Mock Tests & Questions
     */
    public function tests()
    {
        $tests = SiteContentService::getAllTests();
        return view('backend.tests.index', compact('tests'));
    }

    public function storeTest(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:50',
            'duration_minutes' => 'required|integer|min:1',
            'passing_percentage' => 'required|integer|min:1|max:100',
        ]);

        $slug = $request->input('slug') ?: Str::slug($request->title);
        $catMap = ['mdcat' => 'MDCAT', 'nums' => 'NUMS', 'army' => 'Army / AMC'];
        $category = strtolower($request->category);

        MockTest::updateOrCreate(
            ['slug' => $slug],
            [
                'title' => $request->title,
                'category' => $category,
                'category_name' => $catMap[$category] ?? strtoupper($category),
                'badge' => $request->input('badge', 'High Yield'),
                'duration_minutes' => (int) $request->duration_minutes,
                'passing_percentage' => (int) $request->passing_percentage,
                'marks_per_question' => (int) $request->input('marks_per_question', 1),
                'difficulty' => $request->input('difficulty', 'Medium'),
                'description' => $request->input('description', 'Medical mock test practice session.'),
                'is_active' => true,
            ]
        );

        return redirect()->route('admin.tests')->with('success', 'Mock test "' . $request->title . '" saved!');
    }

    public function deleteTest($slug)
    {
        MockTest::where('slug', $slug)->delete();
        return redirect()->route('admin.tests')->with('success', 'Mock test deleted.');
    }

    /**
     * Manage E-Library Vault
     */
    public function elibrary()
    {
        $resources = SiteContentService::getAllResources();
        return view('backend.elibrary.index', compact('resources'));
    }

    public function storeResource(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:60',
            'subject' => 'nullable|string|max:80',
        ]);

        $slug = $request->input('slug') ?: Str::slug($request->title);

        ElibraryResource::updateOrCreate(
            ['slug' => $slug],
            [
                'title' => $request->title,
                'category' => strtolower($request->category),
                'exam_category' => strtolower($request->input('exam_category', $request->category)),
                'category_name' => ucwords(str_replace('-', ' ', $request->category)),
                'subject' => $request->input('subject', 'All Subjects'),
                'badge' => $request->input('badge', 'Free PDF'),
                'pages' => $request->input('pages', '60 Pages'),
                'size' => $request->input('size', '4.2 MB'),
                'description' => $request->input('description', 'Official study guide and notes.'),
                'file_name' => $slug . '.pdf',
                'is_active' => true,
            ]
        );

        return redirect()->route('admin.elibrary')->with('success', 'Resource "' . $request->title . '" published!');
    }

    public function deleteResource($slug)
    {
        ElibraryResource::where('slug', $slug)->delete();
        return redirect()->route('admin.elibrary')->with('success', 'E-Library resource deleted.');
    }

    /**
     * Manage Blog & Articles
     */
    public function blogs()
    {
        $blogs = SiteContentService::getAllBlogs();
        return view('backend.blogs.index', compact('blogs'));
    }

    public function storeBlog(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:80',
            'short_description' => 'nullable|string',
            'content' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $slug = $request->input('slug') ?: Str::slug($request->title);
        $imagePath = $request->input('existing_image');
        if ($request->hasFile('image_file')) {
            $imagePath = SiteContentService::uploadImage($request->file('image_file'), 'blogs');
        }

        $rawBody = trim(strip_tags((string) $request->input('content', 'Medical preparation article.')));
        $paragraphs = array_values(array_filter(array_map('trim', preg_split("/\r\n|\n|\r/", $rawBody) ?: [])));
        if (empty($paragraphs)) {
            $paragraphs = ['Medical entry test preparation guide by DoctorsInn Academic Faculty.'];
        }

        Blog::updateOrCreate(
            ['slug' => $slug],
            [
                'title' => $request->title,
                'category' => $request->category,
                'short_description' => $request->input('short_description') ?: Str::limit($rawBody, 140),
                'content' => $paragraphs,
                'image' => $imagePath ?: 'frontend/img/blog/blog_1_1.jpg',
                'read_time' => $request->input('read_time', '5 min read'),
                'author' => [
                    'name' => $request->input('author_name', 'DoctorsInn Academic Team'),
                    'designation' => 'Senior Medical Mentors',
                    'image' => 'frontend/img/blog/blog-author.jpg',
                    'bio' => 'DoctorsInn provides high-yield MDCAT, NUMS & AMC entry test preparation, comprehensive mock series, and personalized mentorship across Pakistan.',
                ],
                'tags' => ['MDCAT', 'Preparation'],
                'date_day' => date('d'),
                'date_month' => date('M'),
                'date_year' => date('Y'),
                'is_published' => true,
            ]
        );

        return redirect()->route('admin.blogs')->with('success', 'Article "' . $request->title . '" saved and published!');
    }

    public function deleteBlog($slug)
    {
        Blog::where('slug', $slug)->delete();
        return redirect()->route('admin.blogs')->with('success', 'Article deleted.');
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
        $cms = SiteContentService::getSettings();
        return view('backend.settings.index', compact('cms'));
    }

    public function saveSettings(Request $request)
    {
        $keys = [
            'site_name', 'contact_phone_1', 'whatsapp_number',
            'contact_email_1', 'contact_address',
        ];
        foreach ($keys as $k) {
            if ($request->has($k)) {
                SiteContent::where('key', $k)->update(['value' => trim((string) $request->input($k))]);
            }
        }
        SiteContentService::flushCache();

        return redirect()->route('admin.settings')->with('success', 'Platform & Academy Settings saved and synced live!');
    }
}
