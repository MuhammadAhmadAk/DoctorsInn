<?php

namespace App\Console\Commands;

use App\Models\Course;
use App\Services\SiteContentService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class SyncCoursesDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'courses:sync-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all courses and rich 3-tier curriculum (Modules -> Chapters -> Topics & Quizzes) to MySQL database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting Course Database Synchronization...');

        $curriculumData = [];
        $curriculumFile = database_path('data/courses_curriculum.json');
        if (file_exists($curriculumFile)) {
            $curriculumData = json_decode(file_get_contents($curriculumFile), true) ?: [];
            $this->info('Loaded curriculum data from: ' . $curriculumFile);
        } else {
            $this->warn('Notice: database/data/courses_curriculum.json not found, using config fallbacks.');
        }

        $coursesConfig = config('courses', []);
        $this->info('Found ' . count($coursesConfig) . ' course templates in catalog.');

        $order = 1;
        $tableRows = [];

        foreach ($coursesConfig as $slug => $c) {
            $curriculum = null;
            if (!empty($curriculumData[$slug]['modules'])) {
                $curriculum = $curriculumData[$slug]['modules'];
            } elseif (!empty($c['curriculum']) && isset($c['curriculum'][0]['chapters'])) {
                $curriculum = $c['curriculum'];
            }

            // Calculate dynamic counts
            $modulesCount = is_array($curriculum) ? count($curriculum) : 0;
            $chaptersCount = 0;
            $topicsCount = 0;
            $quizzesCount = 0;

            if (is_array($curriculum)) {
                foreach ($curriculum as $mod) {
                    if (!empty($mod['chapters']) && is_array($mod['chapters'])) {
                        foreach ($mod['chapters'] as $ch) {
                            $chaptersCount++;
                            if (!empty($ch['topics']) && is_array($ch['topics'])) {
                                foreach ($ch['topics'] as $top) {
                                    if (!empty($top['isQuiz']) || ($top['type'] ?? '') === 'quiz') {
                                        $quizzesCount++;
                                    } else {
                                        $topicsCount++;
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $lessonsBadge = $c['lessons'] ?? null;
            if ($topicsCount > 0 || $quizzesCount > 0) {
                $lessonsBadge = "{$topicsCount} Lectures • {$quizzesCount} Quizzes";
            }

            $course = Course::updateOrCreate(
                ['slug' => $c['slug'] ?? $slug],
                [
                    'category' => $c['category'] ?? 'mdcat',
                    'category_name' => $c['category_name'] ?? 'MDCAT',
                    'title' => $c['title'] ?? 'Course Title',
                    'price' => $c['price'] ?? 'Free',
                    'original_price' => $c['original_price'] ?? null,
                    'rating' => $c['rating'] ?? '4.9',
                    'rating_count' => $c['rating_count'] ?? '1k',
                    'lessons' => $lessonsBadge,
                    'students' => $c['students'] ?? '500+ Students',
                    'duration' => $c['duration'] ?? '60 Days',
                    'level' => $c['level'] ?? 'Beginner to Advanced',
                    'language' => $c['language'] ?? 'Urdu / English',
                    'instructor' => $c['instructor'] ?? 'DoctorsInn Medical Faculty',
                    'image' => $c['image'] ?? 'frontend/img/course/course1-1.jpg',
                    'detail_image' => $c['detail_image'] ?? ($c['image'] ?? 'frontend/img/course/course1-1.jpg'),
                    'instructor_image' => $c['instructor_image'] ?? 'frontend/img/course/course-thumb1-1.png',
                    'success_badge' => $c['success_badge'] ?? '300+ Students Selected',
                    'overview' => $c['overview'] ?? '',
                    'what_will_you_learn' => $c['what_will_you_learn'] ?? [],
                    'curriculum' => $curriculum,
                    'instructor_info' => $c['instructor_info'] ?? ['name' => $c['instructor'] ?? 'DoctorsInn'],
                    'success_stories' => $c['success_stories'] ?? [],
                    'reviews' => $c['reviews'] ?? [],
                    'is_featured' => true,
                    'is_active' => true,
                    'sort_order' => $order++,
                ]
            );

            $tableRows[] = [
                $course->id,
                $course->slug,
                \Illuminate\Support\Str::limit($course->title, 35),
                $modulesCount . ' Mods',
                $chaptersCount . ' Chs',
                $topicsCount . ' Lecs',
                $quizzesCount . ' Qzs',
            ];
        }

        $this->table(['ID', 'Slug', 'Title', 'Modules', 'Chapters', 'Lectures', 'Quizzes'], $tableRows);

        // Flush site cache so frontend loads new database entries
        Cache::forget(SiteContentService::CACHE_COURSES);
        $this->info('Database courses synced and cache flushed successfully!');
        return 0;
    }
}
