<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\Course;
use App\Models\ElibraryResource;
use App\Models\Faq;
use App\Models\Instructor;
use App\Models\MockTest;
use App\Models\SiteContent;
use App\Models\Testimonial;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class SiteContentService
{
    public const CACHE_SETTINGS = 'cms_site_settings_v1';
    public const CACHE_HOME = 'cms_home_payload_v1';
    public const CACHE_COURSES = 'cms_courses_all_v1';
    public const CACHE_BLOGS = 'cms_blogs_all_v1';
    public const CACHE_TESTS = 'cms_tests_all_v1';
    public const CACHE_ELIBRARY = 'cms_elibrary_all_v1';
    public const CACHE_FAQS = 'cms_faqs_all_v1';

    /**
     * Flush all frontend & homepage CMS caches immediately after Admin edits.
     */
    public static function flushCache(): void
    {
        foreach ([
            self::CACHE_SETTINGS,
            self::CACHE_HOME,
            self::CACHE_COURSES,
            self::CACHE_BLOGS,
            self::CACHE_TESTS,
            self::CACHE_ELIBRARY,
            self::CACHE_FAQS,
        ] as $key) {
            Cache::forget($key);
        }
    }

    /**
     * Upload an image cleanly under public/uploads/{subfolder} (Hostinger-safe, no symlink needed).
     */
    public static function uploadImage(?UploadedFile $file, string $subfolder = 'cms'): ?string
    {
        if (!$file || !$file->isValid()) {
            return null;
        }

        $targetDir = public_path('uploads/' . trim($subfolder, '/'));
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $ext = strtolower($file->getClientOriginalExtension() ?: 'jpg');
        $safeName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $filename = ($safeName ?: 'media') . '-' . time() . '-' . Str::random(5) . '.' . $ext;

        $file->move($targetDir, $filename);

        return 'uploads/' . trim($subfolder, '/') . '/' . $filename;
    }

    /**
     * Get cached site-wide CMS key => value map (single O(1) memory lookup per request).
     */
    public static function getSettings(): array
    {
        static $inMemory = null;
        if ($inMemory !== null) {
            return $inMemory;
        }

        $defaults = self::defaultSiteContentMap();

        try {
            if (!Schema::hasTable('site_contents')) {
                return $inMemory = $defaults;
            }

            $dbMap = Cache::rememberForever(self::CACHE_SETTINGS, function () {
                return SiteContent::query()
                    ->select(['key', 'value'])
                    ->pluck('value', 'key')
                    ->toArray();
            });

            return $inMemory = array_merge($defaults, array_filter($dbMap, fn ($v) => $v !== null && $v !== ''));
        } catch (\Throwable $e) {
            return $inMemory = $defaults;
        }
    }

    public static function get(string $key, $default = ''): string
    {
        $settings = self::getSettings();
        return (string) ($settings[$key] ?? $default);
    }

    /**
     * Fetch optimized, indexed, and cached Homepage payload (zero lag on load).
     */
    public static function getHomeData(): array
    {
        try {
            return Cache::rememberForever(self::CACHE_HOME, function () {
                $courses = self::getAllCourses();

                $blogs = Schema::hasTable('blogs')
                    ? Blog::query()
                        ->select(['id', 'slug', 'title', 'category', 'short_description', 'image', 'read_time', 'date_day', 'date_month', 'date_year'])
                        ->where('is_published', true)
                        ->orderBy('sort_order')
                        ->orderByDesc('created_at')
                        ->limit(3)
                        ->get()
                        ->map(fn ($b) => $b->toFrontendArray())
                        ->toArray()
                    : array_slice(config('blogs', []), 0, 3);

                if (empty($blogs)) {
                    $blogs = array_slice(config('blogs', []), 0, 3);
                }

                $instructors = Schema::hasTable('instructors')
                    ? Instructor::query()
                        ->select(['id', 'name', 'designation', 'image', 'rating', 'facebook_url', 'twitter_url', 'linkedin_url', 'instagram_url'])
                        ->where('is_active', true)
                        ->orderBy('sort_order')
                        ->get()
                        ->toArray()
                    : [];

                $testimonials = Schema::hasTable('testimonials')
                    ? Testimonial::query()
                        ->select(['id', 'headline', 'quote', 'student_name', 'student_batch', 'avatar', 'rating'])
                        ->where('is_active', true)
                        ->orderBy('sort_order')
                        ->get()
                        ->toArray()
                    : [];

                $homeFaqs = Schema::hasTable('faqs')
                    ? Faq::query()
                        ->select(['id', 'question', 'answer'])
                        ->where('is_active', true)
                        ->where('show_on_home', true)
                        ->orderBy('sort_order')
                        ->limit(6)
                        ->get()
                        ->toArray()
                    : [];

                return compact('courses', 'blogs', 'instructors', 'testimonials', 'homeFaqs');
            });
        } catch (\Throwable $e) {
            return [
                'courses' => config('courses', []),
                'blogs' => array_slice(config('blogs', []), 0, 3),
                'instructors' => [],
                'testimonials' => [],
                'homeFaqs' => [],
            ];
        }
    }

    /**
     * Indexed, cached course catalog keyed by slug (compatible with all Blade views).
     */
    public static function getAllCourses(): array
    {
        try {
            if (!Schema::hasTable('courses')) {
                return config('courses', []);
            }

            $list = Cache::rememberForever(self::CACHE_COURSES, function () {
                return Course::query()
                    ->where('is_active', true)
                    ->orderBy('sort_order')
                    ->orderBy('id')
                    ->get()
                    ->mapWithKeys(fn ($c) => [$c->slug => $c->toFrontendArray()])
                    ->toArray();
            });

            return !empty($list) ? $list : config('courses', []);
        } catch (\Throwable $e) {
            return config('courses', []);
        }
    }

    public static function getAllBlogs(): array
    {
        try {
            if (!Schema::hasTable('blogs')) {
                return config('blogs', []);
            }

            $list = Cache::rememberForever(self::CACHE_BLOGS, function () {
                return Blog::query()
                    ->where('is_published', true)
                    ->orderBy('sort_order')
                    ->orderByDesc('created_at')
                    ->get()
                    ->mapWithKeys(fn ($b) => [$b->slug => $b->toFrontendArray()])
                    ->toArray();
            });

            return !empty($list) ? $list : config('blogs', []);
        } catch (\Throwable $e) {
            return config('blogs', []);
        }
    }

    public static function getAllTests(): array
    {
        try {
            if (!Schema::hasTable('mock_tests')) {
                return config('tests.tests', []);
            }

            $list = Cache::rememberForever(self::CACHE_TESTS, function () {
                return MockTest::query()
                    ->where('is_active', true)
                    ->orderBy('sort_order')
                    ->orderBy('id')
                    ->get()
                    ->mapWithKeys(fn ($t) => [$t->slug => $t->toFrontendArray()])
                    ->toArray();
            });

            return !empty($list) ? $list : config('tests.tests', []);
        } catch (\Throwable $e) {
            return config('tests.tests', []);
        }
    }

    public static function getAllResources(): array
    {
        try {
            if (!Schema::hasTable('elibrary_resources')) {
                return config('elibrary.resources', []);
            }

            $list = Cache::rememberForever(self::CACHE_ELIBRARY, function () {
                return ElibraryResource::query()
                    ->where('is_active', true)
                    ->orderBy('sort_order')
                    ->orderBy('id')
                    ->get()
                    ->map(fn ($r) => $r->toFrontendArray())
                    ->toArray();
            });

            return !empty($list) ? $list : config('elibrary.resources', []);
        } catch (\Throwable $e) {
            return config('elibrary.resources', []);
        }
    }

    public static function getAllFaqs(): array
    {
        try {
            if (!Schema::hasTable('faqs')) {
                return [];
            }

            return Cache::rememberForever(self::CACHE_FAQS, function () {
                return Faq::query()
                    ->where('is_active', true)
                    ->orderBy('sort_order')
                    ->get()
                    ->toArray();
            });
        } catch (\Throwable $e) {
            return [];
        }
    }

    /**
     * Default values matching existing static template content (used as safe fallback + initial seed).
     */
    public static function defaultSiteContentMap(): array
    {
        return [
            // General & Branding
            'site_name' => 'DoctorsInnElite',
            'site_tagline' => 'Pakistan #1 MDCAT Preparation Platform',
            'site_logo' => 'frontend/img/logo/logo.svg',
            'site_logo_white' => 'frontend/img/logo/logo-white.svg',
            'site_favicon' => 'frontend/img/logo/favicon.svg',

            // Contact & Social
            'contact_email_1' => 'info@doctorsinnelite.com',
            'contact_email_2' => 'support@doctorsinnelite.com',
            'contact_phone_1' => '+92 300 1234567',
            'contact_phone_2' => '+92 312 9876543',
            'whatsapp_number' => '923001234567',
            'contact_address' => 'DoctorsInn Main Campus, Lahore, Pakistan',
            'facebook_url' => 'https://www.facebook.com/',
            'twitter_url' => 'https://www.twitter.com/',
            'linkedin_url' => 'https://www.linkedin.com/',
            'youtube_url' => 'https://www.youtube.com/',
            'instagram_url' => 'https://www.instagram.com/',

            // Hero Section
            'hero_subtitle' => 'PREPARE. PRACTICE. SUCCEED.',
            'hero_title_1' => 'Crack MDCAT,',
            'hero_title_2' => 'Build Your Medical Career',
            'hero_description' => 'DoctorsInnElite provides structured MDCAT preparation, expert-led course, and full-length mock tests to help you secure your seat in top medical colleges.',
            'hero_btn_1_text' => 'ENROLL NOW',
            'hero_btn_2_text' => 'EXPLORE COURSE',

            // About Section (Home & About Page)
            'about_subtitle' => 'Get To Know About Us',
            'about_title' => "Pakistan's Trusted MDCAT Preparation Platform",
            'about_description' => 'DoctorsInnElite is dedicated to helping aspiring medical students crack MDCAT and secure admissions in top medical colleges. With expert instructors, structured course, and real exam-style mock tests — we prepare you for success.',
            'about_mission_title' => 'OUR MISSION:',
            'about_mission_text' => 'To provide every medical aspirant with affordable, high-quality MDCAT preparation through structured course, mock tests, and expert mentorship.',
            'about_vision_title' => 'OUR VISION:',
            'about_vision_text' => "To become Pakistan's #1 online platform for medical entry test preparation — empowering students from every city and background.",
            'about_image_1' => 'frontend/img/normal/about_2_1.jpg',
            'about_image_2' => 'frontend/img/normal/about_2_2.jpg',

            // Features Strip (5 highlights)
            'feature_1_title' => '8+ Online Courses',
            'feature_1_icon' => 'frontend/img/icon/counter-icon2-1.svg',
            'feature_2_title' => 'Lifetime Access',
            'feature_2_icon' => 'frontend/img/icon/counter-icon2-2.svg',
            'feature_3_title' => 'Value For Money',
            'feature_3_icon' => 'frontend/img/icon/counter-icon2-3.svg',
            'feature_4_title' => '24/7 Student Support',
            'feature_4_icon' => 'frontend/img/icon/counter-icon2-4.svg',
            'feature_5_title' => 'WhatsApp Community',
            'feature_5_icon' => 'frontend/img/icon/counter-icon2-5.svg',

            // Work Process Section
            'process_subtitle' => 'Work Process',
            'process_title' => 'How It Works',
            'process_image' => 'frontend/img/normal/process-thumb2-1.png',
            'process_step1_title' => 'Register & Create Your Account',
            'process_step1_text' => 'Sign up on DoctorsInnElite and create your free student account in minutes.',
            'process_step2_title' => 'Choose Your Course',
            'process_step2_text' => 'Pick your MDCAT, NUMS, or AMC course and enroll instantly.',
            'process_step3_title' => 'Learn & Ace Your Exam',
            'process_step3_text' => 'Study lessons, attempt mock tests, and track your progress.',

            // Promo CTA Cards
            'promo_1_badge' => 'POPULAR COURSE',
            'promo_1_title' => '1000+ Students Already Enrolled!',
            'promo_1_btn' => 'ENROLL NOW',
            'promo_1_image' => 'frontend/img/normal/cta-thumb2-1.png',
            'promo_2_badge' => 'TRENDING COURSE',
            'promo_2_title' => 'MDCAT 2026? Start Today!',
            'promo_2_btn' => 'EXPLORE NOW',
            'promo_2_image' => 'frontend/img/normal/cta-thumb2-2.png',

            // FAQ & Team Headers
            'team_subtitle' => 'Our Teachers',
            'team_title' => 'Meet Our Professional Teachers',
            'testi_subtitle' => 'Testimonials',
            'testi_title' => 'What Our Students Say!',
            'faq_subtitle' => "Faq's",
            'faq_title' => 'Frequently Asked Questions',
            'faq_image_1' => 'frontend/img/normal/faq_1_1.jpg',
            'faq_image_2' => 'frontend/img/normal/faq_1_2.jpg',
            'faq_counter_image' => 'frontend/img/normal/volunteer-group2.png',
            'faq_counter_number' => '1K +',
            'faq_counter_label' => 'Active students',

            // Footer
            'footer_about_text' => 'DoctorsInnElite empowers medical aspirants with expert-led MDCAT preparation, mock tests, and mentorship to secure top medical college admissions.',
            'footer_copyright' => 'Copyright © 2026 DoctorsInnElite, All rights reserved.',
        ];
    }
}
