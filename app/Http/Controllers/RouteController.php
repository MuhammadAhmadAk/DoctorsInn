<?php

namespace App\Http\Controllers;

use App\Mail\ContactInquiryMail;
use App\Models\ElibraryResource;
use App\Models\MockTest;
use App\Models\Notification;
use App\Models\TestAttempt;
use App\Services\SiteContentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class RouteController extends Controller
{
    public function Frontend_Home()
    {
        $homeData = SiteContentService::getHomeData();

        return view('frontend.index', $homeData);
    }

    public function Frontend_About()
    {
        $homeData = SiteContentService::getHomeData();

        return view('frontend.pages.about', [
            'instructors' => $homeData['instructors'] ?? [],
            'testimonials' => $homeData['testimonials'] ?? [],
        ]);
    }

    public function Frontend_Faq()
    {
        $faqs = SiteContentService::getAllFaqs();

        return view('frontend.pages.faq', compact('faqs'));
    }

    public function Frontend_Contact()
    {
        return view('frontend.pages.contact');
    }

    public function Frontend_ContactSubmit(Request $request)
    {
        if ($request->filled('website')) {
            return back()->with('contact_success', 'Thanks! Your message has been sent — we usually reply within one business day.');
        }

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:60'],
            'last_name' => ['required', 'string', 'max:60'],
            'email' => ['required', 'email', 'max:120'],
            'phone' => ['nullable', 'string', 'max:25'],
            'subject' => ['nullable', Rule::in([
                'Course & admissions',
                'Mock tests & results',
                'Payments & billing',
                'Technical support',
                'General enquiry',
            ])],
            'message' => ['required', 'string', 'max:3000'],
            'consent' => ['accepted'],
        ], [
            'consent.accepted' => 'Please accept the privacy policy to continue.',
        ]);

        $name = trim(preg_replace('/[\r\n]+/', ' ', $validated['first_name'] . ' ' . $validated['last_name']));
        $to = SiteContentService::getSettings()['contact_email_1'] ?? 'info@doctorsinnelite.com';

        try {
            Mail::to($to)->send(new ContactInquiryMail(
                $name,
                $validated['email'],
                $validated['phone'] ?: null,
                $validated['subject'] ?: null,
                $validated['message'],
            ));
        } catch (\Throwable $e) {
            Log::error('Contact form delivery failed', ['exception' => $e]);

            return back()
                ->withInput()
                ->with('contact_error', "Sorry, your message couldn't be sent right now. Please email us directly at {$to}.");
        }

        return back()->with('contact_success', 'Thanks! Your message has been sent — we usually reply within one business day.');
    }

    public function Frontend_PrivacyPolicy()
    {
        return view('frontend.pages.privacy-policy');
    }

    public function Frontend_TermsConditions()
    {
        return view('frontend.pages.terms-conditions');
    }

    public function Frontend_Error()
    {
        return view('frontend.pages.error');
    }

    public function Frontend_ELibrary(Request $request)
    {
        $categoriesConfig = config('elibrary.categories', []);
        $allResources = collect(SiteContentService::getAllResources());

        $resourceCategories = [
            'all' => [
                'label' => $categoriesConfig['all']['label'] ?? 'All Resources',
                'icon' => $categoriesConfig['all']['icon'] ?? 'fa-solid fa-layer-group',
                'resources' => $allResources,
            ],
            'mdcat' => [
                'label' => $categoriesConfig['mdcat']['label'] ?? 'MDCAT',
                'icon' => $categoriesConfig['mdcat']['icon'] ?? 'fa-solid fa-stethoscope',
                'resources' => $allResources->filter(fn ($r) => ($r['category'] ?? '') === 'mdcat' || ($r['exam_category'] ?? '') === 'mdcat'),
            ],
            'nums' => [
                'label' => $categoriesConfig['nums']['label'] ?? 'NUMS',
                'icon' => $categoriesConfig['nums']['icon'] ?? 'fa-solid fa-hospital-user',
                'resources' => $allResources->filter(fn ($r) => ($r['category'] ?? '') === 'nums' || ($r['exam_category'] ?? '') === 'nums'),
            ],
            'army' => [
                'label' => $categoriesConfig['army']['label'] ?? 'Army / AMC',
                'icon' => $categoriesConfig['army']['icon'] ?? 'fa-solid fa-shield-halved',
                'resources' => $allResources->filter(fn ($r) => ($r['category'] ?? '') === 'army' || ($r['exam_category'] ?? '') === 'army'),
            ],
            'past-papers' => [
                'label' => $categoriesConfig['past-papers']['label'] ?? 'Past Papers',
                'icon' => $categoriesConfig['past-papers']['icon'] ?? 'fa-solid fa-clock-rotate-left',
                'resources' => $allResources->filter(fn ($r) => ($r['category'] ?? '') === 'past-papers'),
            ],
            'notes' => [
                'label' => $categoriesConfig['notes']['label'] ?? 'Short Notes',
                'icon' => $categoriesConfig['notes']['icon'] ?? 'fa-solid fa-book-bookmark',
                'resources' => $allResources->filter(fn ($r) => ($r['category'] ?? '') === 'notes'),
            ],
        ];

        return view('frontend.pages.elibrary', compact('resourceCategories', 'allResources'));
    }

    public function Frontend_DownloadResource($slug)
    {
        if (! auth()->check() && ! session()->has('admin_user')) {
            return redirect()->route('login', ['redirect' => route('e-library.download', $slug)])
                ->with('warning', 'Please log in to your student account to download this resource.');
        }

        $resources = SiteContentService::getAllResources();
        $found = null;
        foreach ($resources as $res) {
            if ($res['slug'] === $slug || (string) $res['id'] === (string) $slug) {
                $found = $res;
                break;
            }
        }

        if (! $found) {
            return redirect()->route('e-library')->with('error', 'Resource not found.');
        }

        $fileName = $found['file_name'] ?? ($found['slug'] . '.pdf');
        $absolute = $this->resolveResourcePath($found['file_path'] ?? '', $found['slug'] ?? $slug);

        if (! $absolute) {
            return redirect()->route('e-library')
                ->with('error', 'This resource file is not available yet. Please check back soon.');
        }

        ElibraryResource::where('slug', $found['slug'])->increment('downloads');
        SiteContentService::flushCache();

        return response()->download($absolute, $fileName);
    }

    /**
     * Resolve an e-library file path inside public/ and reject anything else.
     */
    protected function resolveResourcePath(string $filePath, string $slug): ?string
    {
        $publicRoot = realpath(public_path());
        if (! $publicRoot) {
            return null;
        }

        $candidates = [];

        if ($filePath !== '') {
            $candidates[] = preg_match('#^([A-Za-z]:|/)#', $filePath) ? $filePath : public_path($filePath);
        }

        // Legacy storage location used before the admin upload field existed.
        $candidates[] = public_path('uploads/elibrary/' . $slug . '.pdf');
        $candidates[] = public_path('uploads/elibrary/' . $filePath);

        foreach ($candidates as $candidate) {
            if ($candidate === '' || ! is_file($candidate)) {
                continue;
            }

            $real = realpath($candidate);
            if ($real && str_starts_with(str_replace('\\', '/', $real), str_replace('\\', '/', $publicRoot))) {
                return $real;
            }
        }

        return null;
    }

    // Courses
    public function Frontend_Course()
    {
        $courses = SiteContentService::getAllCourses();

        return view('frontend.pages.courses.course', compact('courses'));
    }

    public function Frontend_CourseDetails(Request $request, $slug = null)
    {
        $courses = SiteContentService::getAllCourses();
        $slug = $slug ?? $request->query('slug');

        $course = null;
        if ($slug) {
            foreach ($courses as $c) {
                if ($c['slug'] === $slug || (string) $c['id'] === (string) $slug) {
                    $course = $c;
                    break;
                }
            }
        }

        if (! $course && ! empty($courses)) {
            $course = reset($courses);
        }

        if (! $course) {
            abort(404);
        }

        return view('frontend.pages.courses.course-details', compact('course', 'courses'));
    }

    public function Frontend_MyCourses(Request $request, $slug = null)
    {
        if (! auth()->check()) {
            return redirect()->route('login', ['redirect' => route('student.courses')]);
        }

        return $slug
            ? redirect()->route('student.classroom', $slug)
            : redirect()->route('student.classroom');
    }

    public function Frontend_Cart()
    {
        // Cart page removed — redirect to courses
        return redirect()->route('course');
    }

    // User Account
    public function Frontend_Profile()
    {
        $courses = SiteContentService::getAllCourses();

        return view('frontend.pages.authentication.profile', compact('courses'));
    }

    // Blogs
    public function Frontend_Blog(Request $request)
    {
        $allBlogs = SiteContentService::getAllBlogs();
        $blogs = $allBlogs;

        $selectedCategory = $request->query('category');
        $selectedTag = $request->query('tag');
        $searchQuery = $request->query('search');

        if ($selectedCategory) {
            $blogs = array_filter($blogs, function ($b) use ($selectedCategory) {
                return strcasecmp($b['category'] ?? '', $selectedCategory) === 0;
            });
        }

        if ($selectedTag) {
            $blogs = array_filter($blogs, function ($b) use ($selectedTag) {
                $tags = array_map('strtolower', $b['tags'] ?? []);
                return in_array(strtolower($selectedTag), $tags);
            });
        }

        if ($searchQuery) {
            $query = strtolower(trim($searchQuery));
            $blogs = array_filter($blogs, function ($b) use ($query) {
                return str_contains(strtolower($b['title'] ?? ''), $query)
                    || str_contains(strtolower($b['short_description'] ?? ''), $query)
                    || str_contains(strtolower($b['category'] ?? ''), $query);
            });
        }

        // Build categories with count
        $categoryCounts = [];
        foreach ($allBlogs as $b) {
            $cat = $b['category'] ?? 'General';
            $categoryCounts[$cat] = ($categoryCounts[$cat] ?? 0) + 1;
        }
        $categories = [];
        foreach ($categoryCounts as $name => $count) {
            $categories[] = ['name' => $name, 'count' => $count];
        }

        // Build popular tags
        $allTags = [];
        foreach ($allBlogs as $b) {
            if (!empty($b['tags'])) {
                foreach ($b['tags'] as $t) {
                    $allTags[$t] = ($allTags[$t] ?? 0) + 1;
                }
            }
        }
        arsort($allTags);
        $popularTags = array_keys(array_slice($allTags, 0, 10));

        // Recent posts (latest 3)
        $recentPosts = array_slice($allBlogs, 0, 3);

        return view('frontend.pages.blog', compact(
            'blogs',
            'categories',
            'popularTags',
            'recentPosts',
            'selectedCategory',
            'selectedTag',
            'searchQuery'
        ));
    }

    public function Frontend_BlogDetails(Request $request, $slug = null)
    {
        $allBlogs = SiteContentService::getAllBlogs();
        $slug = $slug ?? $request->query('slug');

        $blog = null;
        $currentIndex = null;
        $keys = array_keys($allBlogs);
        $total = count($keys);

        if ($slug) {
            foreach ($allBlogs as $idx => $b) {
                if ($b['slug'] === $slug || (string) $b['id'] === (string) $slug) {
                    $blog = $b;
                    $currentIndex = array_search($idx, $keys, true);
                    break;
                }
            }
        }

        if (!$blog && !empty($allBlogs)) {
            $blog = reset($allBlogs);
            $currentIndex = 0;
        }

        if (!$blog) {
            return redirect()->route('blog');
        }

        // Previous and Next Post
        $prevBlog = null;
        $nextBlog = null;
        if ($currentIndex !== false && $currentIndex !== null && $total > 1) {
            $prevIndex = ($currentIndex - 1 + $total) % $total;
            $nextIndex = ($currentIndex + 1) % $total;
            $prevBlog = $allBlogs[$keys[$prevIndex]] ?? null;
            $nextBlog = $allBlogs[$keys[$nextIndex]] ?? null;
        }

        // Recent posts excluding current blog
        $recentPosts = array_filter($allBlogs, function ($b) use ($blog) {
            return $b['slug'] !== $blog['slug'];
        });
        $recentPosts = array_slice($recentPosts, 0, 3);

        // Categories with count
        $categoryCounts = [];
        foreach ($allBlogs as $b) {
            $cat = $b['category'] ?? 'General';
            $categoryCounts[$cat] = ($categoryCounts[$cat] ?? 0) + 1;
        }
        $categories = [];
        foreach ($categoryCounts as $name => $count) {
            $categories[] = ['name' => $name, 'count' => $count];
        }

        // Popular tags
        $allTags = [];
        foreach ($allBlogs as $b) {
            if (!empty($b['tags'])) {
                foreach ($b['tags'] as $t) {
                    $allTags[$t] = ($allTags[$t] ?? 0) + 1;
                }
            }
        }
        arsort($allTags);
        $popularTags = array_keys(array_slice($allTags, 0, 10));

        return view('frontend.pages.blog-details', compact(
            'blog',
            'prevBlog',
            'nextBlog',
            'recentPosts',
            'categories',
            'popularTags'
        ));
    }

    // =========================================================================
    // ONLINE TESTS & MCQS SYSTEM
    // =========================================================================

    public function Frontend_Tests(Request $request)
    {
        $categoriesConfig = config('tests.categories', []);
        $allTests = collect(SiteContentService::getAllTests())
            ->filter(fn ($t) => ! empty($t['questions']));

        $testCategories = [
            'all' => [
                'label' => $categoriesConfig['all']['label'] ?? 'All Mock Tests',
                'icon' => $categoriesConfig['all']['icon'] ?? 'fa-solid fa-layer-group',
                'tests' => $allTests,
            ],
            'mdcat' => [
                'label' => $categoriesConfig['mdcat']['label'] ?? 'MDCAT',
                'icon' => $categoriesConfig['mdcat']['icon'] ?? 'fa-solid fa-stethoscope',
                'tests' => $allTests->filter(fn ($t) => ($t['category'] ?? '') === 'mdcat'),
            ],
            'nums' => [
                'label' => $categoriesConfig['nums']['label'] ?? 'NUMS',
                'icon' => $categoriesConfig['nums']['icon'] ?? 'fa-solid fa-hospital-user',
                'tests' => $allTests->filter(fn ($t) => ($t['category'] ?? '') === 'nums'),
            ],
            'army' => [
                'label' => $categoriesConfig['army']['label'] ?? 'Army / AMC',
                'icon' => $categoriesConfig['army']['icon'] ?? 'fa-solid fa-shield-halved',
                'tests' => $allTests->filter(fn ($t) => ($t['category'] ?? '') === 'army'),
            ],
        ];

        return view('frontend.pages.tests.index', compact('testCategories', 'allTests'));
    }

    public function Frontend_TakeTest(Request $request, $slug)
    {
        // Enforce Login: User must be logged in to attempt test
        $user = auth()->user();
        if (! $user) {
            return redirect()->route('login', ['redirect' => route('test.take', $slug)])
                ->with('warning', 'Please log in to your student account to attempt this test.');
        }

        $tests = SiteContentService::getAllTests();
        $test = $tests[$slug] ?? null;

        if (! $test) {
            return redirect()->route('tests')->with('error', 'Test not found.');
        }

        if (empty($test['questions'])) {
            return redirect()->route('tests')->with('error', 'This practice test has no questions yet. Please check back soon.');
        }

        return view('frontend.pages.tests.take-test', compact('test', 'user'));
    }

    public function Frontend_SubmitTest(Request $request, $slug)
    {
        $user = auth()->user();
        if (! $user) {
            return redirect()->route('login', ['redirect' => route('test.take', $slug)])
                ->with('warning', 'Please log in to your account to submit the test.');
        }

        $tests = SiteContentService::getAllTests();
        $test = $tests[$slug] ?? null;

        if (! $test) {
            return redirect()->route('tests')->with('error', 'Test not found.');
        }

        if (empty($test['questions'])) {
            return redirect()->route('tests')->with('error', 'This practice test has no questions yet and cannot be submitted.');
        }

        $submittedAnswers = $request->input('answers', []);
        $timeSpentSeconds = (int) $request->input('time_spent_seconds', 0);

        $totalQuestions = count($test['questions']);
        $correctCount = 0;
        $incorrectCount = 0;
        $skippedCount = 0;
        $breakdown = [];

        foreach ($test['questions'] as $q) {
            $qId = $q['id'];
            $userChoice = $submittedAnswers[$qId] ?? null;
            $isCorrect = false;

            if ($userChoice === null || $userChoice === '') {
                $skippedCount++;
            } elseif ($userChoice === $q['correct']) {
                $correctCount++;
                $isCorrect = true;
            } else {
                $incorrectCount++;
            }

            $breakdown[] = [
                'question' => $q,
                'user_choice' => $userChoice,
                'correct_choice' => $q['correct'],
                'is_correct' => $isCorrect,
                'is_skipped' => ($userChoice === null || $userChoice === ''),
                'explanation' => $q['explanation'],
            ];
        }

        $marksPerQ = $test['marks_per_question'] ?? 1;
        $score = $correctCount * $marksPerQ;
        $totalMarks = $totalQuestions * $marksPerQ;
        $percentage = $totalMarks > 0 ? round(($score / $totalMarks) * 100, 1) : 0;
        $passingPercentage = $test['passing_percentage'] ?? 70;
        $passed = $percentage >= $passingPercentage;

        $subjectStats = [];
        foreach ($breakdown as $item) {
            $subject = trim((string) ($item['question']['subject'] ?? 'General')) ?: 'General';

            if (! isset($subjectStats[$subject])) {
                $subjectStats[$subject] = ['attempted' => 0, 'correct' => 0];
            }

            if (! $item['is_skipped']) {
                $subjectStats[$subject]['attempted']++;
            }
            if ($item['is_correct']) {
                $subjectStats[$subject]['correct']++;
            }
        }

        $attempt = TestAttempt::create([
            'user_id' => $user->id,
            // Config-based tests have no DB row, so only link a real mock_tests id.
            'mock_test_id' => MockTest::where('slug', $test['slug'] ?? $slug)->value('id'),
            'test_slug' => $test['slug'] ?? $slug,
            'test_title' => $test['title'] ?? 'Mock Test',
            'test_category_name' => $test['category_name'] ?? 'MDCAT',
            'marks_per_question' => (int) $marksPerQ,
            'total_questions' => $totalQuestions,
            'correct_count' => $correctCount,
            'incorrect_count' => $incorrectCount,
            'skipped_count' => $skippedCount,
            'score' => $score,
            'total_marks' => $totalMarks,
            'percentage' => $percentage,
            'passed' => $passed,
            'passing_percentage' => (int) $passingPercentage,
            'time_spent_seconds' => max(0, $timeSpentSeconds),
            'breakdown' => $breakdown,
            'subject_stats' => $subjectStats,
        ]);

        Notification::create([
            'user_id' => $user->id,
            'type' => 'result',
            'title' => 'Mock test completed: ' . ($test['title'] ?? 'Mock Test'),
            'message' => "You scored {$score}/{$totalMarks} ({$percentage}%)" . ($passed ? ' — Passed.' : ' — Needs review.'),
            'url' => route('test.result', $attempt->id),
        ]);

        return redirect()->route('test.result', $attempt->id);
    }

    /**
     * Stored attempt result (survives refreshes and is linked from history).
     */
    public function Frontend_TestResult(Request $request, TestAttempt $attempt)
    {
        $user = auth()->user();

        if (! $user || (int) $attempt->user_id !== (int) $user->id) {
            abort(403, 'You are not allowed to view this result.');
        }

        $mins = intdiv((int) $attempt->time_spent_seconds, 60);
        $secs = (int) $attempt->time_spent_seconds % 60;

        $test = [
            'slug' => $attempt->test_slug,
            'title' => $attempt->test_title,
            'category_name' => $attempt->test_category_name,
            'marks_per_question' => (int) $attempt->marks_per_question,
        ];

        $resultData = [
            'test' => $test,
            'user' => ['name' => $user->name],
            'total_questions' => (int) $attempt->total_questions,
            'correct_count' => (int) $attempt->correct_count,
            'incorrect_count' => (int) $attempt->incorrect_count,
            'skipped_count' => (int) $attempt->skipped_count,
            'score' => (int) $attempt->score,
            'total_marks' => (int) $attempt->total_marks,
            'percentage' => (int) round($attempt->percentage),
            'passed' => (bool) $attempt->passed,
            'passing_percentage' => (int) $attempt->passing_percentage,
            'time_spent' => sprintf('%02d:%02d mins', $mins, $secs),
            'breakdown' => $attempt->breakdown ?? [],
            'submitted_at' => $attempt->created_at?->format('d M, Y — h:i A') ?? '',
        ];

        return view('frontend.pages.tests.test-result', compact('resultData', 'test'));
    }
}
