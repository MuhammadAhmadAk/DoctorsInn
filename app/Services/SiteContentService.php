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
     * Upload and automatically optimize an image (resized + converted to WebP) under public/uploads/{subfolder}.
     */
    public static function uploadImage(?UploadedFile $file, string $subfolder = 'cms'): ?string
    {
        return ImageOptimizerService::storeOptimized($file, $subfolder);
    }

    /**
     * Shared cache-first query helper: checks Schema::hasTable ONLY on cold cache miss.
     */
    protected static function rememberTableQuery(string $cacheKey, string $table, callable $fetcher, $fallback = [], bool $fallbackIfEmpty = false)
    {
        try {
            return Cache::rememberForever($cacheKey, function () use ($table, $fetcher, $fallback, $fallbackIfEmpty) {
                if (!Schema::hasTable($table)) {
                    return is_callable($fallback) ? $fallback() : $fallback;
                }

                $result = $fetcher();
                if ($fallbackIfEmpty && empty($result) && is_callable($fallback)) {
                    return $fallback();
                }

                return $result ?? [];
            });
        } catch (\Throwable $e) {
            return is_callable($fallback) ? $fallback() : $fallback;
        }
    }

    /**
     * Get cached site-wide CMS key => value map (single O(1) memory lookup per request, 0 queries on hit).
     */
    public static function getSettings(): array
    {
        static $inMemory = null;
        if ($inMemory !== null) {
            return $inMemory;
        }

        $defaults = self::defaultSiteContentMap();

        $dbMap = self::rememberTableQuery(
            self::CACHE_SETTINGS,
            'site_contents',
            fn () => SiteContent::query()->select(['key', 'value'])->pluck('value', 'key')->toArray(),
            []
        );

        return $inMemory = array_merge($defaults, array_filter($dbMap, fn ($v) => $v !== null && $v !== ''));
    }

    public static function get(string $key, $default = ''): string
    {
        $settings = self::getSettings();
        return (string) ($settings[$key] ?? $default);
    }

    /**
     * Fetch optimized, indexed, and cached Homepage payload (0 MySQL queries on warm hit).
     */
    public static function getHomeData(): array
    {
        try {
            return Cache::rememberForever(self::CACHE_HOME, function () {
                $courses = Schema::hasTable('courses')
                    ? Course::query()
                        ->select(['id', 'slug', 'category', 'category_name', 'title', 'price', 'original_price', 'rating', 'rating_count', 'lessons', 'students', 'image'])
                        ->where('is_active', true)
                        ->orderBy('sort_order')
                        ->orderBy('id')
                        ->get()
                        ->mapWithKeys(fn ($c) => [$c->slug => $c->toFrontendArray()])
                        ->toArray()
                    : [];

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
                'courses' => [],
                'blogs' => array_slice(config('blogs', []), 0, 3),
                'instructors' => [],
                'testimonials' => [],
                'homeFaqs' => [],
            ];
        }
    }

    /**
     * Indexed, cached course catalog keyed by slug (strictly from database).
     */
    public static function getAllCourses(): array
    {
        return self::rememberTableQuery(
            self::CACHE_COURSES,
            'courses',
            fn () => Course::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get()
                ->mapWithKeys(fn ($c) => [$c->slug => $c->toFrontendArray()])
                ->toArray(),
            fn () => []
        );
    }

    public static function getAllBlogs(): array
    {
        return self::rememberTableQuery(
            self::CACHE_BLOGS,
            'blogs',
            fn () => Blog::query()
                ->where('is_published', true)
                ->orderBy('sort_order')
                ->orderByDesc('created_at')
                ->get()
                ->mapWithKeys(fn ($b) => [$b->slug => $b->toFrontendArray()])
                ->toArray(),
            fn () => config('blogs', [])
        );
    }

    public static function getAllTests(): array
    {
        return self::rememberTableQuery(
            self::CACHE_TESTS,
            'mock_tests',
            fn () => MockTest::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get()
                ->mapWithKeys(fn ($t) => [$t->slug => $t->toFrontendArray()])
                ->toArray(),
            fn () => config('tests.tests', [])
        );
    }

    public static function getAllResources(): array
    {
        return self::rememberTableQuery(
            self::CACHE_ELIBRARY,
            'elibrary_resources',
            fn () => ElibraryResource::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get()
                ->map(fn ($r) => $r->toFrontendArray())
                ->toArray(),
            fn () => config('elibrary.resources', [])
        );
    }

    public static function getAllFaqs(): array
    {
        return self::rememberTableQuery(
            self::CACHE_FAQS,
            'faqs',
            fn () => Faq::query()
                ->select(['id', 'question', 'answer', 'category', 'show_on_home'])
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->toArray(),
            []
        );
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
