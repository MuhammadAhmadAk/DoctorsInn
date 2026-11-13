<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Course;
use App\Models\ElibraryResource;
use App\Models\Faq;
use App\Models\Instructor;
use App\Models\MockTest;
use App\Models\SiteContent;
use App\Models\Testimonial;
use App\Services\SiteContentService;
use Illuminate\Database\Seeder;

class SiteCmsSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedSiteContents();
        $this->seedCourses();
        $this->seedBlogs();
        $this->seedTests();
        $this->seedElibrary();
        $this->seedInstructors();
        $this->seedTestimonials();
        $this->seedFaqs();

        SiteContentService::flushCache();
    }

    protected function seedSiteContents(): void
    {
        $schema = [
            // General & Branding
            ['general', 'site_name', 'Platform Name', 'text', 1],
            ['general', 'site_tagline', 'Site Tagline / SEO Title', 'text', 2],
            ['general', 'site_logo', 'Header Light Logo', 'image', 3],
            ['general', 'site_logo_white', 'Footer / Dark Logo', 'image', 4],
            ['general', 'site_favicon', 'Site Favicon', 'image', 5],

            // Contact & Social
            ['contact', 'contact_email_1', 'Primary Email Address', 'text', 1],
            ['contact', 'contact_email_2', 'Support Email Address', 'text', 2],
            ['contact', 'contact_phone_1', 'Primary Phone / Helpline', 'text', 3],
            ['contact', 'contact_phone_2', 'Secondary Phone', 'text', 4],
            ['contact', 'whatsapp_number', 'WhatsApp Number (digits only)', 'text', 5],
            ['contact', 'contact_address', 'Campus Address', 'textarea', 6],
            ['contact', 'facebook_url', 'Facebook URL', 'url', 7],
            ['contact', 'twitter_url', 'Twitter / X URL', 'url', 8],
            ['contact', 'linkedin_url', 'LinkedIn URL', 'url', 9],
            ['contact', 'youtube_url', 'YouTube URL', 'url', 10],
            ['contact', 'instagram_url', 'Instagram URL', 'url', 11],

            // Hero Section
            ['hero', 'hero_subtitle', 'Hero Top Badge', 'text', 1],
            ['hero', 'hero_title_1', 'Hero Title Line 1', 'text', 2],
            ['hero', 'hero_title_2', 'Hero Title Line 2', 'text', 3],
            ['hero', 'hero_description', 'Hero Description', 'textarea', 4],
            ['hero', 'hero_btn_1_text', 'Primary Button Text', 'text', 5],
            ['hero', 'hero_btn_2_text', 'Secondary Button Text', 'text', 6],

            // About Section
            ['about', 'about_subtitle', 'About Section Subtitle', 'text', 1],
            ['about', 'about_title', 'About Main Heading', 'text', 2],
            ['about', 'about_description', 'About Description', 'textarea', 3],
            ['about', 'about_mission_title', 'Mission Heading', 'text', 4],
            ['about', 'about_mission_text', 'Mission Statement', 'textarea', 5],
            ['about', 'about_vision_title', 'Vision Heading', 'text', 6],
            ['about', 'about_vision_text', 'Vision Statement', 'textarea', 7],
            ['about', 'about_image_1', 'About Main Photo 1', 'image', 8],
            ['about', 'about_image_2', 'About Secondary Photo 2', 'image', 9],

            // Features Strip
            ['features', 'feature_1_title', 'Feature 1 Title', 'text', 1],
            ['features', 'feature_1_icon', 'Feature 1 Icon/Image', 'image', 2],
            ['features', 'feature_2_title', 'Feature 2 Title', 'text', 3],
            ['features', 'feature_2_icon', 'Feature 2 Icon/Image', 'image', 4],
            ['features', 'feature_3_title', 'Feature 3 Title', 'text', 5],
            ['features', 'feature_3_icon', 'Feature 3 Icon/Image', 'image', 6],
            ['features', 'feature_4_title', 'Feature 4 Title', 'text', 7],
            ['features', 'feature_4_icon', 'Feature 4 Icon/Image', 'image', 8],
            ['features', 'feature_5_title', 'Feature 5 Title', 'text', 9],
            ['features', 'feature_5_icon', 'Feature 5 Icon/Image', 'image', 10],

            // Work Process Section
            ['process', 'process_subtitle', 'Process Subtitle', 'text', 1],
            ['process', 'process_title', 'Process Heading', 'text', 2],
            ['process', 'process_image', 'Process Right Showcase Image', 'image', 3],
            ['process', 'process_step1_title', 'Step 01 Title', 'text', 4],
            ['process', 'process_step1_text', 'Step 01 Description', 'textarea', 5],
            ['process', 'process_step2_title', 'Step 02 Title', 'text', 6],
            ['process', 'process_step2_text', 'Step 02 Description', 'textarea', 7],
            ['process', 'process_step3_title', 'Step 03 Title', 'text', 8],
            ['process', 'process_step3_text', 'Step 03 Description', 'textarea', 9],

            // Promo CTA Cards
            ['promo', 'promo_1_badge', 'Promo Card 1 Badge', 'text', 1],
            ['promo', 'promo_1_title', 'Promo Card 1 Headline', 'text', 2],
            ['promo', 'promo_1_btn', 'Promo Card 1 Button Text', 'text', 3],
            ['promo', 'promo_1_image', 'Promo Card 1 Image', 'image', 4],
            ['promo', 'promo_2_badge', 'Promo Card 2 Badge', 'text', 5],
            ['promo', 'promo_2_title', 'Promo Card 2 Headline', 'text', 6],
            ['promo', 'promo_2_btn', 'Promo Card 2 Button Text', 'text', 7],
            ['promo', 'promo_2_image', 'Promo Card 2 Image', 'image', 8],

            // FAQ, Team & Footer
            ['sections', 'team_subtitle', 'Teachers Section Subtitle', 'text', 1],
            ['sections', 'team_title', 'Teachers Section Heading', 'text', 2],
            ['sections', 'testi_subtitle', 'Testimonials Subtitle', 'text', 3],
            ['sections', 'testi_title', 'Testimonials Heading', 'text', 4],
            ['sections', 'faq_subtitle', 'FAQ Subtitle', 'text', 5],
            ['sections', 'faq_title', 'FAQ Heading', 'text', 6],
            ['sections', 'faq_image_1', 'FAQ Showcase Photo 1', 'image', 7],
            ['sections', 'faq_image_2', 'FAQ Showcase Photo 2', 'image', 8],
            ['sections', 'faq_counter_image', 'FAQ Counter Group Image', 'image', 9],
            ['sections', 'faq_counter_number', 'FAQ Counter Number', 'text', 10],
            ['sections', 'faq_counter_label', 'FAQ Counter Label', 'text', 11],
            ['footer', 'footer_about_text', 'Footer About Paragraph', 'textarea', 1],
            ['footer', 'footer_copyright', 'Footer Copyright Notice', 'text', 2],
        ];

        $defaults = SiteContentService::defaultSiteContentMap();

        foreach ($schema as [$section, $key, $label, $type, $order]) {
            SiteContent::firstOrCreate(
                ['key' => $key],
                [
                    'section' => $section,
                    'label' => $label,
                    'type' => $type,
                    'value' => $defaults[$key] ?? '',
                    'sort_order' => $order,
                ]
            );
        }
    }

    protected function seedCourses(): void
    {
        $curriculumData = [];
        $curriculumFile = database_path('data/courses_curriculum.json');
        if (file_exists($curriculumFile)) {
            $curriculumData = json_decode(file_get_contents($curriculumFile), true) ?: [];
        }

        $order = 1;
        foreach (config('courses', []) as $slug => $c) {
            $curriculum = null;
            if (!empty($curriculumData[$slug]['modules'])) {
                $curriculum = $curriculumData[$slug]['modules'];
            } elseif (!empty($c['curriculum']) && isset($c['curriculum'][0]['chapters'])) {
                $curriculum = $c['curriculum'];
            }

            Course::updateOrCreate(
                ['slug' => $c['slug'] ?? $slug],
                [
                    'category' => $c['category'] ?? 'mdcat',
                    'category_name' => $c['category_name'] ?? 'MDCAT',
                    'title' => $c['title'] ?? 'Course',
                    'price' => $c['price'] ?? 'Free',
                    'original_price' => $c['original_price'] ?? null,
                    'rating' => $c['rating'] ?? '4.9',
                    'rating_count' => $c['rating_count'] ?? '1k',
                    'lessons' => $c['lessons'] ?? '10+ Lessons',
                    'students' => $c['students'] ?? '500+ Students',
                    'duration' => $c['duration'] ?? '60 Days',
                    'level' => $c['level'] ?? 'Beginner to Advanced',
                    'language' => $c['language'] ?? 'Urdu / English',
                    'instructor' => $c['instructor'] ?? 'DoctorsInn',
                    'image' => $c['image'] ?? 'frontend/img/course/course1-1.jpg',
                    'detail_image' => $c['detail_image'] ?? ($c['image'] ?? 'frontend/img/course/course1-1.jpg'),
                    'instructor_image' => $c['instructor_image'] ?? 'frontend/img/course/course-thumb1-1.png',
                    'success_badge' => $c['success_badge'] ?? null,
                    'overview' => $c['overview'] ?? '',
                    'what_will_you_learn' => $c['what_will_you_learn'] ?? [],
                    'curriculum' => $curriculum,
                    'instructor_info' => $c['instructor_info'] ?? [],
                    'success_stories' => $c['success_stories'] ?? [],
                    'reviews' => $c['reviews'] ?? [],
                    'is_featured' => true,
                    'is_active' => true,
                    'sort_order' => $order++,
                ]
            );
        }
    }

    protected function seedBlogs(): void
    {
        $order = 1;
        foreach (config('blogs', []) as $slug => $b) {
            Blog::firstOrCreate(
                ['slug' => $b['slug'] ?? $slug],
                [
                    'title' => $b['title'] ?? 'Article',
                    'category' => $b['category'] ?? 'MDCAT Preparation',
                    'short_description' => $b['short_description'] ?? '',
                    'content' => $b['content'] ?? '',
                    'image' => $b['image'] ?? 'frontend/img/blog/blog_1_1.jpg',
                    'author' => is_array($b['author'] ?? null) ? $b['author'] : ['name' => $b['author'] ?? 'DoctorsInn Editorial Team'],
                    'tags' => $b['tags'] ?? [],
                    'read_time' => $b['read_time'] ?? '5 min read',
                    'date_day' => $b['date_day'] ?? '01',
                    'date_month' => $b['date_month'] ?? 'Nov',
                    'date_year' => $b['date_year'] ?? '2026',
                    'is_published' => true,
                    'sort_order' => $order++,
                ]
            );
        }
    }

    protected function seedTests(): void
    {
        $order = 1;
        foreach (config('tests.tests', []) as $slug => $t) {
            MockTest::firstOrCreate(
                ['slug' => $t['slug'] ?? $slug],
                [
                    'title' => $t['title'] ?? 'Mock Test',
                    'category' => $t['category'] ?? 'mdcat',
                    'category_name' => $t['category_name'] ?? 'MDCAT',
                    'badge' => $t['badge'] ?? 'High Yield',
                    'duration_minutes' => $t['duration_minutes'] ?? 30,
                    'total_questions' => $t['total_questions'] ?? count($t['questions'] ?? []),
                    'marks_per_question' => $t['marks_per_question'] ?? 1,
                    'passing_percentage' => $t['passing_percentage'] ?? 70,
                    'difficulty' => $t['difficulty'] ?? 'Medium',
                    'attempts' => $t['attempts'] ?? '1.5k+',
                    'image' => $t['image'] ?? 'frontend/img/course/course1-1.jpg',
                    'description' => $t['description'] ?? '',
                    'questions' => $t['questions'] ?? [],
                    'is_active' => true,
                    'sort_order' => $order++,
                ]
            );
        }
    }

    protected function seedElibrary(): void
    {
        $order = 1;
        foreach (config('elibrary.resources', []) as $res) {
            ElibraryResource::firstOrCreate(
                ['slug' => $res['slug']],
                [
                    'title' => $res['title'],
                    'category' => $res['category'] ?? 'mdcat',
                    'exam_category' => $res['exam_category'] ?? 'mdcat',
                    'category_name' => $res['category_name'] ?? 'MDCAT',
                    'subject' => $res['subject'] ?? 'All Subjects',
                    'badge' => $res['badge'] ?? 'Free PDF',
                    'format' => $res['format'] ?? 'PDF',
                    'pages' => $res['pages'] ?? '60 Pages',
                    'size' => $res['size'] ?? '4.0 MB',
                    'downloads' => $res['downloads'] ?? '2.5k+',
                    'rating' => $res['rating'] ?? '4.9',
                    'image' => $res['image'] ?? 'frontend/img/course/course1-1.jpg',
                    'description' => $res['description'] ?? '',
                    'file_name' => $res['file_name'] ?? ($res['slug'] . '.pdf'),
                    'is_active' => true,
                    'sort_order' => $order++,
                ]
            );
        }
    }

    protected function seedInstructors(): void
    {
        if (Instructor::count() > 0) {
            return;
        }

        $items = [
            ['name' => 'Dr. Salman Tariq', 'designation' => 'Biology Lead Instructor', 'image' => 'frontend/img/team/team_2_1.jpg', 'rating' => '4.9'],
            ['name' => 'Prof. Michel Jemison', 'designation' => 'Chemistry Specialist', 'image' => 'frontend/img/team/team_2_2.jpg', 'rating' => '4.9'],
            ['name' => 'Prof. Jacob Jones', 'designation' => 'Physics & Numericals Expert', 'image' => 'frontend/img/team/team_2_3.jpg', 'rating' => '4.9'],
            ['name' => 'Dr. Hamza Malik', 'designation' => 'AMC & Logical Mentor', 'image' => 'frontend/img/team/team_2_4.jpg', 'rating' => '4.9'],
        ];

        foreach ($items as $i => $row) {
            Instructor::create(array_merge($row, [
                'facebook_url' => 'https://facebook.com/',
                'twitter_url' => 'https://twitter.com/',
                'linkedin_url' => 'https://linkedin.com/',
                'instagram_url' => 'https://instagram.com/',
                'is_active' => true,
                'sort_order' => $i + 1,
            ]));
        }
    }

    protected function seedTestimonials(): void
    {
        if (Testimonial::count() > 0) {
            return;
        }

        $items = [
            [
                'headline' => 'AMC Exam Mein Pass Ho Gaya!',
                'quote' => 'Every topic ka lecture, notes, aur MCQ practice sab kuch tha. Koi bhi problem hoti toh turant solve ho jati. Only because of this course I passed the AMC test!',
                'student_name' => 'Muhammad Abdul Rafay',
                'student_batch' => 'AMC — Ansaar Batch | Gujrat',
                'avatar' => 'frontend/img/testimonial/testi_2_1.png',
                'rating' => '5.0',
            ],
            [
                'headline' => 'Best Choice for PMA Preparation!',
                'quote' => 'Lessons were clear, well-structured and easy to follow. I passed all my tests with excellent results. Truly the best choice for PMA prep!',
                'student_name' => 'Hammad Gulzar',
                'student_batch' => 'PMA — Iqbal Batch | Bahawalpur',
                'avatar' => 'frontend/img/testimonial/testi_2_2.png',
                'rating' => '5.0',
            ],
            [
                'headline' => 'Anytime Support — Always Available!',
                'quote' => 'Lectures include all books and they give their best to make us understand everything. We asked any question anytime and they were always available. Thanks Sir!',
                'student_name' => 'Amna',
                'student_batch' => 'MDCAT Student',
                'avatar' => 'frontend/img/testimonial/testi_2_3.png',
                'rating' => '5.0',
            ],
            [
                'headline' => 'Yaqeen Batch Bohat Zabardast Hai!',
                'quote' => 'MDCAT ke liye yahan bahut zaroori information aur helpful resources milte hain. Group administration friendly hai aur overall bahut useful Online Educational Centre hai.',
                'student_name' => 'Ali Khan',
                'student_batch' => 'MDCAT — Yaqeen Batch Group B | Quetta',
                'avatar' => 'frontend/img/testimonial/testi_2_1.png',
                'rating' => '5.0',
            ],
            [
                'headline' => 'Outstanding Teachers & Methodology!',
                'quote' => 'The teachers are highly professional, cooperative and supportive. Test sessions are very helpful. Highly recommended for serious aspirants!',
                'student_name' => 'Noor Khan',
                'student_batch' => 'MDCAT Enrolled Student | Swat',
                'avatar' => 'frontend/img/testimonial/testi_2_2.png',
                'rating' => '5.0',
            ],
            [
                'headline' => 'High-Quality Notes & Strong Commitment!',
                'quote' => 'Impressed with this platform! High-quality notes and strong commitment to users. Truly delivered on its promise!',
                'student_name' => 'Armish Shoukat',
                'student_batch' => 'AFNS — Afaaq Batch | Abbottabad',
                'avatar' => 'frontend/img/testimonial/testi_2_3.png',
                'rating' => '5.0',
            ],
        ];

        foreach ($items as $i => $row) {
            Testimonial::create(array_merge($row, [
                'is_active' => true,
                'sort_order' => $i + 1,
            ]));
        }
    }

    protected function seedFaqs(): void
    {
        if (Faq::count() > 0) {
            return;
        }

        $items = [
            [
                'question' => 'What courses does DoctorsInnElite offer?',
                'answer' => 'We offer MDCAT, NUMS, AMC, and AFNS preparation courses including mock tests, full-length papers, and comprehensive test sessions.',
                'category' => 'courses',
                'show_on_home' => true,
            ],
            [
                'question' => 'Are the courses available online?',
                'answer' => 'Yes! All our courses are 100% online. Study anytime, anywhere at your own pace with video lectures, notes, and MCQ banks.',
                'category' => 'general',
                'show_on_home' => true,
            ],
            [
                'question' => 'How do I enroll in a course?',
                'answer' => 'Simply create a free student account, browse our courses, and click Enroll Now to get started immediately.',
                'category' => 'admissions',
                'show_on_home' => true,
            ],
        ];

        foreach ($items as $i => $row) {
            Faq::create(array_merge($row, [
                'is_active' => true,
                'sort_order' => $i + 1,
            ]));
        }
    }
}
