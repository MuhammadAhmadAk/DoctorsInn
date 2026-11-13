<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Course;
use App\Models\ElibraryResource;
use App\Models\MockTest;
use App\Models\SiteContent;
use App\Services\SiteContentService;
use App\Services\Mp4FastStartService;
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
     * Manage Courses & Batches (Direct from Database)
     */
    public function courses()
    {
        $courses = Course::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->mapWithKeys(fn ($c) => [$c->slug => $c->toFrontendArray()])
            ->toArray();

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
     * Show Form to Edit Existing Course & Curriculum
     */
    public function editCourse($slug)
    {
        $course = Course::where('slug', $slug)->first();
        if (!$course) {
            return redirect()->route('admin.courses')->with('error', 'Course not found in database.');
        }
        return view('backend.courses.create', compact('course'));
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
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif,gif|max:8192',
        ]);

        $slug = $request->input('slug') ?: Str::slug($request->title);
        $catMap = [
            'mdcat' => 'MDCAT',
            'nums' => 'NUMS',
            'army' => 'Army / AMC',
            'past_papers' => 'FLPs / Past Papers',
        ];
        $category = strtolower($request->category);

        $imagePath = $request->input('existing_image');
        if ($request->hasFile('thumbnail')) {
            $imagePath = SiteContentService::uploadImage($request->file('thumbnail'), 'courses');
        }

        // Process Curriculum / Modules JSON
        $curriculum = null;
        if ($request->filled('curriculum_json')) {
            $decoded = json_decode($request->input('curriculum_json'), true);
            if (is_array($decoded)) {
                $curriculum = $decoded;
            }
        } elseif ($request->filled('curriculum')) {
            $curriculum = is_array($request->curriculum) ? $request->curriculum : json_decode($request->curriculum, true);
        }

        // Calculate dynamic lecture and quiz counts from modules hierarchy
        $totalTopics = 0;
        $totalQuizzes = 0;
        $totalModules = is_array($curriculum) ? count($curriculum) : 0;
        if (is_array($curriculum)) {
            foreach ($curriculum as $mod) {
                if (!empty($mod['chapters']) && is_array($mod['chapters'])) {
                    foreach ($mod['chapters'] as $ch) {
                        if (!empty($ch['topics']) && is_array($ch['topics'])) {
                            foreach ($ch['topics'] as $top) {
                                if (!empty($top['isQuiz']) || ($top['type'] ?? '') === 'quiz') {
                                    $totalQuizzes++;
                                } else {
                                    $totalTopics++;
                                }
                            }
                        }
                    }
                }
            }
        }

        $lessonsBadge = $request->input('lessons');
        if (empty($lessonsBadge) && ($totalTopics > 0 || $totalQuizzes > 0)) {
            $lessonsBadge = "{$totalTopics} Lectures • {$totalQuizzes} Quizzes";
        } elseif (empty($lessonsBadge)) {
            $lessonsBadge = "{$totalModules} Modules";
        }

        $existing = Course::where('slug', $slug)->first();
        $finalImage = $imagePath ?: ($existing ? $existing->image : 'frontend/img/course/course1-1.jpg');

        Course::updateOrCreate(
            ['slug' => $slug],
            [
                'title' => $request->title,
                'category' => $category,
                'category_name' => $catMap[$category] ?? strtoupper($category),
                'price' => $request->price,
                'original_price' => $request->input('original_price'),
                'duration' => $request->duration,
                'lessons' => $lessonsBadge,
                'students' => $request->input('students', '500+ Students'),
                'instructor' => $request->input('instructor', 'DoctorsInn Medical Faculty Panel'),
                'success_badge' => $request->input('success_badge', '300+ Qualifiers in Top Medical Colleges'),
                'overview' => $request->input('overview', 'Structured medical entry test preparation batch.'),
                'image' => $finalImage,
                'detail_image' => $finalImage,
                'curriculum' => $curriculum,
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        SiteContentService::flushCache();

        return redirect()->route('admin.courses')->with('success', 'Course "' . $request->title . '" and 3-Tier Curriculum saved successfully!');
    }

    public function deleteCourse($slug)
    {
        Course::where('slug', $slug)->delete();
        SiteContentService::flushCache();
        return redirect()->route('admin.courses')->with('success', 'Course permanently removed from database.');
    }

    /**
     * Handle Direct Video Lecture Upload (MP4, WebM, MOV, MKV, etc.)
     */
    public function uploadCourseVideo(Request $request)
    {
        $request->validate([
            'video' => 'required|file|mimes:mp4,webm,mov,mkv,avi,m4v,qt|max:1572864',
        ]);

        if (!$request->hasFile('video') || !$request->file('video')->isValid()) {
            return response()->json(['success' => false, 'message' => 'Invalid or missing video file.'], 400);
        }

        $file = $request->file('video');
        $targetDir = public_path('uploads/courses/videos');
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeBase = Str::slug($originalName) ?: 'lecture-video';
        $ext = strtolower($file->getClientOriginalExtension() ?: 'mp4');
        $filename = $safeBase . '-' . time() . '-' . Str::random(6) . '.' . $ext;

        $file->move($targetDir, $filename);

        $fullPath = $targetDir . '/' . $filename;

        // ── MP4 Fast Start Optimization ──────────────────────────────────────
        // Moves the moov atom (metadata) to the front of the file so browsers
        // can begin streaming/playing before the entire file is downloaded.
        // Pure PHP implementation — no ffmpeg required.
        $optimized = false;
        $optimizeReason = 'skipped';
        try {
            $optimizer = new Mp4FastStartService();
            $result = $optimizer->optimize($fullPath);
            $optimized = $result['optimized'];
            $optimizeReason = $result['reason'];
        } catch (\Throwable $e) {
            // Non-fatal: video still works, just not fast-start optimized
            $optimizeReason = 'error: ' . $e->getMessage();
        }
        // ─────────────────────────────────────────────────────────────────────

        $relativeUrl = 'uploads/courses/videos/' . $filename;
        $fullUrl = asset($relativeUrl);
        $fileSizeBytes = file_exists($fullPath) ? filesize($fullPath) : 0;
        $formattedSize = round($fileSizeBytes / (1024 * 1024), 2) . ' MB';

        return response()->json([
            'success'      => true,
            'url'          => $fullUrl,
            'relative_url' => $relativeUrl,
            'filename'     => $file->getClientOriginalName(),
            'size'         => $formattedSize,
            'mime'         => $file->getClientMimeType() ?: 'video/mp4',
            'optimized'    => $optimized,
        ]);
    }

    /**
     * Handle Direct Course Resource / PDF Notes Upload
     */
    public function uploadCourseResource(Request $request)
    {
        $request->validate([
            'resource' => 'required|file|mimes:pdf,doc,docx,zip,ppt,pptx|max:102400',
        ]);

        if (!$request->hasFile('resource') || !$request->file('resource')->isValid()) {
            return response()->json(['success' => false, 'message' => 'Invalid or missing document file.'], 400);
        }

        $file = $request->file('resource');
        $targetDir = public_path('uploads/courses/handouts');
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeBase = Str::slug($originalName) ?: 'handout';
        $ext = strtolower($file->getClientOriginalExtension() ?: 'pdf');
        $filename = $safeBase . '-' . time() . '-' . Str::random(6) . '.' . $ext;

        $file->move($targetDir, $filename);

        $relativeUrl = 'uploads/courses/handouts/' . $filename;
        $fullUrl = asset($relativeUrl);
        $fileSizeBytes = file_exists($targetDir . '/' . $filename) ? filesize($targetDir . '/' . $filename) : 0;
        $formattedSize = round($fileSizeBytes / 1024, 1) . ' KB';

        return response()->json([
            'success' => true,
            'url' => $fullUrl,
            'relative_url' => $relativeUrl,
            'filename' => $file->getClientOriginalName(),
            'size' => $formattedSize,
        ]);
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
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif,gif|max:8192',
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
