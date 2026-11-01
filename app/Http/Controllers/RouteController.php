<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function Frontend_Home()
    {
        $courses = config('courses', []);
        $blogs = config('blogs', []);

        return view('frontend.index', compact('courses', 'blogs'));
    }

    public function Frontend_About()
    {
        return view('frontend.pages.about');
    }

    public function Frontend_Faq()
    {
        return view('frontend.pages.faq');
    }

    public function Frontend_Contact()
    {
        return view('frontend.pages.contact');
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
        $allResources = collect(config('elibrary.resources', []));

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
        $resources = config('elibrary.resources', []);
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
        $title = $found['title'] ?? 'DoctorsInn E-Library Resource';

        // Sample valid PDF stream for instant download
        $pdfContent = "%PDF-1.4\n" .
            "1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj\n" .
            "2 0 obj<</Type/Pages/Kids[3 0 R]/Count 1>>endobj\n" .
            "3 0 obj<</Type/Page/MediaBox[0 0 612 792]/Parent 2 0 R/Resources<</Font<</F1 5 0 R>>>>/Contents 4 0 R>>endobj\n" .
            "4 0 obj<</Length 180>>stream\n" .
            "BT /F1 18 Tf 50 720 Td (DoctorsInn Free Study Material) Tj /F1 12 Tf 50 690 Td (" . addslashes(substr($title, 0, 60)) . ") Tj /F1 10 Tf 50 660 Td (Visit www.doctorsinn.pk for full video lectures and practice tests.) Tj ET\n" .
            "endstream\nendobj\n" .
            "5 0 obj<</Type/Font/Subtype/Type1/BaseFont/Helvetica>>endobj\n" .
            "xref\n0 6\n0000000000 65535 f\n0000000009 00000 n\n0000000056 00000 n\n0000000111 00000 n\n0000000224 00000 n\n0000000455 00000 n\n" .
            "trailer<</Size 6/Root 1 0 R>>\nstartxref\n526\n%%EOF";

        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    // Courses
    public function Frontend_Course()
    {
        $courses = config('courses', []);

        return view('frontend.pages.courses.course', compact('courses'));
    }

    public function Frontend_CourseDetails(Request $request, $slug = null)
    {
        $courses = config('courses', []);
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

        return view('frontend.pages.courses.course-details', compact('course', 'courses'));
    }

    public function Frontend_MyCourses(Request $request, $slug = null)
    {
        $courses = config('courses', []);
        $courseParam = $slug ?: $request->query('course');

        $activeCourse = null;
        if ($courseParam) {
            foreach ($courses as $c) {
                if ($c['slug'] === $courseParam || (string) $c['id'] === (string) $courseParam) {
                    $activeCourse = $c;
                    break;
                }
            }
        }

        if (! $activeCourse && ! empty($courses)) {
            $activeCourse = reset($courses);
        }

        $activeCourseSlug = $activeCourse['slug'] ?? 'mdcat-reboot-60-day';

        return view('frontend.pages.courses.my-courses', compact('courses', 'activeCourse', 'activeCourseSlug'));
    }

    public function Frontend_Cart()
    {
        // Cart page removed — redirect to courses
        return redirect()->route('course');
    }

    public function Frontend_Checkout(Request $request)
    {
        $courses = config('courses', []);
        $slug = $request->query('course');

        $course = null;
        if ($slug) {
            foreach ($courses as $c) {
                if ($c['slug'] === $slug || (string) $c['id'] === (string) $slug) {
                    $course = $c;
                    break;
                }
            }
        }

        // If no course found, redirect to courses page
        if (! $course) {
            return redirect()->route('course');
        }

        return view('frontend.pages.courses.checkout', compact('course'));
    }

    // Authentication
    public function Frontend_Login()
    {
        return view('frontend.pages.authentication.login');
    }

    public function Frontend_Register()
    {
        return view('frontend.pages.authentication.register');
    }

    public function Frontend_ForgotPassword()
    {
        return view('frontend.pages.authentication.forgot-password');
    }

    public function Frontend_VerifyCode()
    {
        return view('frontend.pages.authentication.verify-code');
    }

    public function Frontend_ResetPassword()
    {
        return view('frontend.pages.authentication.reset-password');
    }

    // User Account
    public function Frontend_Profile()
    {
        $courses = config('courses', []);

        return view('frontend.pages.authentication.profile', compact('courses'));
    }

    public function Frontend_Notifications()
    {
        return view('frontend.pages.notifications');
    }

    // Blogs
    public function Frontend_Blog(Request $request)
    {
        $allBlogs = config('blogs', []);
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
        $allBlogs = config('blogs', []);
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
        $allTests = collect(config('tests.tests', []));

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
        $user = auth()->user() ?? session('user');
        if (! $user) {
            return redirect()->route('login', ['redirect' => route('test.take', $slug)])
                ->with('warning', 'Please log in to your student account to attempt this test.');
        }

        $tests = config('tests.tests', []);
        $test = $tests[$slug] ?? null;

        if (! $test) {
            return redirect()->route('tests')->with('error', 'Test not found.');
        }

        return view('frontend.pages.tests.take-test', compact('test', 'user'));
    }

    public function Frontend_SubmitTest(Request $request, $slug)
    {
        $user = auth()->user() ?? session('user');
        if (! $user) {
            return redirect()->route('login', ['redirect' => route('test.take', $slug)])
                ->with('warning', 'Please log in to your account to submit the test.');
        }

        $tests = config('tests.tests', []);
        $test = $tests[$slug] ?? null;

        if (! $test) {
            return redirect()->route('tests')->with('error', 'Test not found.');
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

        $mins = floor($timeSpentSeconds / 60);
        $secs = $timeSpentSeconds % 60;
        $formattedTime = sprintf('%02d:%02d mins', $mins, $secs);

        $resultData = [
            'test' => $test,
            'user' => $user,
            'total_questions' => $totalQuestions,
            'correct_count' => $correctCount,
            'incorrect_count' => $incorrectCount,
            'skipped_count' => $skippedCount,
            'score' => $score,
            'total_marks' => $totalMarks,
            'percentage' => $percentage,
            'passed' => $passed,
            'passing_percentage' => $passingPercentage,
            'time_spent' => $formattedTime,
            'breakdown' => $breakdown,
            'submitted_at' => now()->format('d M, Y — h:i A'),
        ];

        return view('frontend.pages.tests.test-result', compact('resultData', 'test'));
    }

    public function Frontend_LoginSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $rawName = explode('@', $request->email)[0];
        $formattedName = ucwords(str_replace(['.', '_', '-'], ' ', $rawName));
        if (empty($formattedName)) {
            $formattedName = 'Student';
        }

        session([
            'user' => [
                'name' => $formattedName,
                'email' => $request->email,
                'avatar' => 'frontend/img/testimonial/testi_2_1.png',
                'enrolled_date' => now()->format('M Y'),
            ],
        ]);

        $redirectUrl = $request->input('redirect');
        if ($redirectUrl) {
            return redirect($redirectUrl)->with('success', 'Welcome, ' . $formattedName . '! You may now begin your test.');
        }

        return redirect()->route('tests')->with('success', 'Welcome back, ' . $formattedName . '!');
    }

    public function Frontend_Logout(Request $request)
    {
        session()->forget('user');
        if (auth()->check()) {
            auth()->logout();
        }

        return redirect()->route('home')->with('success', 'You have been successfully logged out.');
    }
}
