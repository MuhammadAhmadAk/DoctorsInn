<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\ElibraryResource;
use App\Models\MockTest;
use App\Models\MockTestQuestion;
use App\Services\SiteContentService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

/**
 * Seeds a full demo catalog: 5 courses (with modules, chapters, topics and
 * chapter quizzes), 5 mock tests with 15 MCQs each, and 5 e-library handouts.
 *
 * Idempotent: re-running updates rows by slug instead of duplicating them.
 * Run with: php artisan db:seed --class=DemoContentSeeder
 */
class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedMockTests();
        $this->seedCourses();
        $this->seedResources();

        SiteContentService::flushCache();

        $this->command?->info('Demo content ready: 5 courses, 5 mock tests (15 MCQs each), 5 e-library resources.');
    }

    // ------------------------------------------------------------------
    // Courses
    // ------------------------------------------------------------------

    protected function seedCourses(): void
    {
        if (! Schema::hasTable('courses')) {
            return;
        }

        foreach ($this->coursePayloads() as $payload) {
            Course::updateOrCreate(['slug' => $payload['slug']], $payload);
        }
    }

    protected function coursePayloads(): array
    {
        $course = fn (array $overrides) => array_merge([
            'category' => 'mdcat',
            'category_name' => 'MDCAT',
            'price' => 'Rs 12,000',
            'original_price' => 'Rs 18,000',
            'rating' => '4.9',
            'rating_count' => '3.2k',
            'students' => '3.5k+',
            'duration' => '10 Months',
            'level' => 'Beginner to Advanced',
            'language' => 'English / Urdu',
            'image' => 'frontend/img/course/course1-1.jpg',
            'detail_image' => 'frontend/img/course/course1-1.jpg',
            'instructor_image' => 'frontend/img/course/course-thumb1-1.png',
            'success_badge' => 'Top Rated',
            'is_featured' => true,
            'is_active' => true,
        ], $overrides);

        return [
            $course([
                'slug' => 'mdcat-2026-complete-course',
                'title' => 'MDCAT 2026 Complete Preparation Course',
                'lessons' => '96 Lectures • 24 Quizzes',
                'instructor' => 'Dr. Ayesha Khan',
                'sort_order' => 1,
                'overview' => 'A complete, exam-oriented MDCAT programme covering Biology, Chemistry and Physics from the ground up. Every chapter ends with a checkpoint quiz, and each month closes with a full-length mock test so your progress stays measurable. Built around the latest PMDC syllabus with high-yield notes, past-paper analysis and one-to-one doubt support.',
                'what_will_you_learn' => [
                    'Master every MDCAT Biology chapter with high-yield notes and diagrams.',
                    'Solve Chemistry numericals with speed-shortcut techniques.',
                    'Build Physics concepts with formula-first problem practice.',
                    'Revise through 24 checkpoint quizzes and monthly full-length mocks.',
                    'Analyse past papers to spot recurring question patterns.',
                    'Track your readiness with a personal progress dashboard.',
                ],
                'curriculum' => [
                    $this->module('Module 1: Biology Foundations', [
                        $this->chapter('Chapter 1: Cell Structure & Function', [
                            $this->topic('The Cell Membrane & Transport', '28 min'),
                            $this->topic('Organelles and Their Functions', '32 min'),
                            $this->quizTopic('Cell Structure & Function — Checkpoint Quiz', 'biology', 0),
                        ]),
                        $this->chapter('Chapter 2: Cell Division & Genetics', [
                            $this->topic('Mitosis vs Meiosis', '30 min'),
                            $this->topic('Mendelian Genetics & Pedigrees', '26 min'),
                            $this->quizTopic('Cell Division & Genetics — Checkpoint Quiz', 'biology', 5),
                        ]),
                    ]),
                    $this->module('Module 2: Chemistry Essentials', [
                        $this->chapter('Chapter 1: Atomic Structure & Bonding', [
                            $this->topic('Atomic Structure and Periodicity', '24 min'),
                            $this->topic('Chemical Bonding & Hybridization', '28 min'),
                            $this->quizTopic('Atomic Structure & Bonding — Checkpoint Quiz', 'chemistry', 0),
                        ]),
                        $this->chapter('Chapter 2: Organic Chemistry Basics', [
                            $this->topic('Functional Groups Explained', '22 min'),
                            $this->topic('Isomerism & Named Reactions', '25 min'),
                            $this->quizTopic('Organic Chemistry — Checkpoint Quiz', 'chemistry', 5),
                        ]),
                    ]),
                    $this->module('Module 3: Physics Core', [
                        $this->chapter('Chapter 1: Motion & Force', [
                            $this->topic('Kinematics in One Dimension', '26 min'),
                            $this->topic("Newton's Laws with MDCAT Applications", '30 min'),
                            $this->quizTopic('Motion & Force — Checkpoint Quiz', 'physics', 0),
                        ]),
                        $this->chapter('Chapter 2: Work, Energy & Power', [
                            $this->topic('Work, Energy and Conservation Laws', '22 min'),
                            $this->topic('Power, Efficiency & Numerical Practice', '18 min'),
                            $this->quizTopic('Work, Energy & Power — Checkpoint Quiz', 'physics', 5),
                        ]),
                    ]),
                ],
                'instructor_info' => [
                    'name' => 'Dr. Ayesha Khan',
                    'bio' => 'MBBS, King Edward Medical University. Ten years of MDCAT teaching with a focus on concept-first Biology and exam temperament.',
                    'courses' => '12+ Courses',
                    'students' => '8k+ Students',
                ],
                'success_stories' => [
                    ['name' => 'Hamza Raza', 'college' => 'King Edward Medical University', 'selection' => 'MBBS', 'score' => '186/200', 'quote' => 'The checkpoint quizzes exposed my weak chapters early. By the final mock I was consistently above 90%.', 'proof_image' => 'frontend/img/proof/proof-1.png'],
                    ['name' => 'Fatima Noor', 'college' => 'Services Institute of Medical Sciences', 'selection' => 'MBBS', 'score' => '179/200', 'quote' => 'The curriculum order matched the actual paper almost exactly. I never felt lost about what to study next.', 'proof_image' => 'frontend/img/proof/proof-2.png'],
                ],
            ]),

            $course([
                'slug' => 'nums-2026-complete-preparation',
                'title' => 'NUMS 2026 Complete Preparation',
                'category' => 'nums',
                'category_name' => 'NUMS',
                'price' => 'Rs 10,000',
                'original_price' => 'Rs 15,000',
                'rating' => '4.8',
                'rating_count' => '2.1k',
                'lessons' => '72 Lectures • 18 Quizzes',
                'students' => '2.4k+',
                'instructor' => 'Dr. Bilal Ahmed',
                'success_badge' => 'NUMS Specialist',
                'sort_order' => 2,
                'image' => 'frontend/img/course/course1-2.jpg',
                'detail_image' => 'frontend/img/course/course1-2.jpg',
                'overview' => 'Tailored for the NUMS entry test pattern, this course sharpens Biology, Chemistry and Physics with NUMS-style MCQs, assertion-reason items and timed sectional tests. Includes a dedicated merit-strategy session and past-paper walkthroughs.',
                'what_will_you_learn' => [
                    'Understand the exact NUMS paper pattern and subject weightage.',
                    'Practise assertion-reason and multiple-correct style items.',
                    'Cover high-yield Biology, Chemistry and Physics chapters fast.',
                    'Take timed sectional tests that mirror NUMS difficulty.',
                    'Learn the merit calculation and score-targeting strategy.',
                    'Get a final-week revision plan built for NUMS aspirants.',
                ],
                'curriculum' => [
                    $this->module('Module 1: NUMS Biology Focus', [
                        $this->chapter('Chapter 1: High-Yield Cell Biology', [
                            $this->topic('Cell Structure Refresher', '26 min'),
                            $this->topic('Biomolecules and Enzymes', '28 min'),
                            $this->quizTopic('NUMS Biology Warm-up Quiz', 'biology', 2),
                        ]),
                        $this->chapter('Chapter 2: Physiology Essentials', [
                            $this->topic('Circulatory System Essentials', '27 min'),
                            $this->topic('Respiration & Gas Exchange', '24 min'),
                            $this->quizTopic('NUMS Physiology Quiz', 'biology', 8),
                        ]),
                    ]),
                    $this->module('Module 2: NUMS Chemistry Focus', [
                        $this->chapter('Chapter 1: Physical Chemistry Core', [
                            $this->topic('Atomic Structure and Bonding', '24 min'),
                            $this->topic('Equilibrium and Le Chatelier', '26 min'),
                            $this->quizTopic('NUMS Physical Chemistry Quiz', 'chemistry', 2),
                        ]),
                        $this->chapter('Chapter 2: Organic Chemistry Core', [
                            $this->topic('Hydrocarbons and Functional Groups', '23 min'),
                            $this->topic('Reaction Mechanisms Made Simple', '25 min'),
                            $this->quizTopic('NUMS Organic Chemistry Quiz', 'chemistry', 8),
                        ]),
                    ]),
                    $this->module('Module 3: NUMS Physics Focus', [
                        $this->chapter('Chapter 1: Mechanics', [
                            $this->topic('Motion Under Gravity', '22 min'),
                            $this->topic('Momentum and Collisions', '24 min'),
                            $this->quizTopic('NUMS Mechanics Quiz', 'physics', 2),
                        ]),
                        $this->chapter('Chapter 2: Electricity & Magnetism', [
                            $this->topic('Current Electricity Basics', '25 min'),
                            $this->topic('Electromagnetic Induction', '21 min'),
                            $this->quizTopic('NUMS Electricity Quiz', 'physics', 8),
                        ]),
                    ]),
                ],
                'instructor_info' => [
                    'name' => 'Dr. Bilal Ahmed',
                    'bio' => 'MBBS, Army Medical College. NUMS and AMC entry-test mentor with six years of classroom and online teaching experience.',
                    'courses' => '8+ Courses',
                    'students' => '6k+ Students',
                ],
                'success_stories' => [
                    ['name' => 'Areeba Shah', 'college' => 'Army Medical College', 'selection' => 'MBBS', 'score' => '172/200', 'quote' => 'The assertion-reason practice changed everything. NUMS questions finally felt predictable.', 'proof_image' => 'frontend/img/proof/proof-3.png'],
                ],
            ]),

            $course([
                'slug' => 'amc-army-entry-test-course',
                'title' => 'AMC / Army Medical Corps Entry Test Course',
                'category' => 'army',
                'category_name' => 'Army / AMC',
                'price' => 'Rs 9,500',
                'original_price' => 'Rs 14,000',
                'rating' => '4.8',
                'rating_count' => '1.4k',
                'lessons' => '64 Lectures • 16 Quizzes',
                'students' => '1.8k+',
                'instructor' => 'Major (R) Dr. Imran Malik',
                'success_badge' => 'AMC Focused',
                'sort_order' => 3,
                'image' => 'frontend/img/course/course1-3.jpg',
                'detail_image' => 'frontend/img/course/course1-3.jpg',
                'language' => 'English / Urdu',
                'overview' => 'Complete preparation for the Army Medical Corps entry test and selection process. Subject MCQs are paired with intelligence-test drills, interview guidance and a physical-readiness plan so you clear every stage of army selection with confidence.',
                'what_will_you_learn' => [
                    'Cover the AMC subject MCQs across Biology, Chemistry and Physics.',
                    'Practise intelligence-test and verbal reasoning drills.',
                    'Understand initial screening and ISSB assessment stages.',
                    'Prepare for the interview with a question-by-question guide.',
                    'Follow a 30-day physical fitness starter plan.',
                    'Use the full document checklist to avoid last-minute issues.',
                ],
                'curriculum' => [
                    $this->module('Module 1: Subject MCQs', [
                        $this->chapter('Chapter 1: Biology for AMC', [
                            $this->topic('Human Physiology Rapid Review', '28 min'),
                            $this->topic('Genetics and Immunity Highlights', '26 min'),
                            $this->quizTopic('AMC Biology Quiz', 'biology', 10),
                        ]),
                        $this->chapter('Chapter 2: Chemistry for AMC', [
                            $this->topic('Physical Chemistry Essentials', '24 min'),
                            $this->topic('Organic Chemistry Essentials', '25 min'),
                            $this->quizTopic('AMC Chemistry Quiz', 'chemistry', 10),
                        ]),
                    ]),
                    $this->module('Module 2: Physics & English', [
                        $this->chapter('Chapter 1: Physics for AMC', [
                            $this->topic('Mechanics and Electricity Recap', '27 min'),
                            $this->topic('Waves and Modern Physics Recap', '23 min'),
                            $this->quizTopic('AMC Physics Quiz', 'physics', 10),
                        ]),
                        $this->chapter('Chapter 2: English & Verbal', [
                            $this->topic('Grammar Rules Asked in AMC', '20 min'),
                            $this->topic('Vocabulary Building Plan', '18 min'),
                            $this->quizTopic('AMC English Quiz', 'english', 0),
                        ]),
                    ]),
                    $this->module('Module 3: Selection Process', [
                        $this->chapter('Chapter 1: Intelligence & ISSB', [
                            $this->topic('Intelligence Test Pattern Walkthrough', '22 min'),
                            $this->topic('ISSB Assessment Explained', '24 min'),
                        ]),
                        $this->chapter('Chapter 2: Interview & Fitness', [
                            $this->topic('Interview Preparation Checklist', '19 min'),
                            $this->topic('Physical Training Starter Plan', '17 min'),
                        ]),
                    ]),
                ],
                'instructor_info' => [
                    'name' => 'Major (R) Dr. Imran Malik',
                    'bio' => 'Retired army medical officer with hands-on knowledge of AMC selection, ISSB assessment and interview boards.',
                    'courses' => '6+ Courses',
                    'students' => '5k+ Students',
                ],
                'success_stories' => [
                    ['name' => 'Muhammad Umar', 'college' => 'Army Medical College Rawalpindi', 'selection' => 'MBBS', 'score' => 'Recommended', 'quote' => 'The selection-process module prepared me for every stage, from screening to the final interview.', 'proof_image' => 'frontend/img/proof/proof-4.png'],
                ],
            ]),

            $course([
                'slug' => 'biology-high-yield-crash-course',
                'title' => 'Biology High-Yield Crash Course',
                'category' => 'mdcat',
                'category_name' => 'MDCAT',
                'price' => 'Rs 4,500',
                'original_price' => 'Rs 7,000',
                'rating' => '4.9',
                'rating_count' => '980',
                'lessons' => '36 Lectures • 9 Quizzes',
                'students' => '1.2k+',
                'duration' => '6 Weeks',
                'level' => 'Intermediate',
                'instructor' => 'Dr. Sana Yousaf',
                'success_badge' => 'Crash Course',
                'sort_order' => 4,
                'image' => 'frontend/img/course/course1-4.jpg',
                'detail_image' => 'frontend/img/course/course1-4.jpg',
                'overview' => 'A six-week sprint through the highest-yield MDCAT Biology content. Built for students who have covered the syllabus once and now need speed, recall and past-paper targeted revision. Every session ends with spaced-repetition style MCQ drills.',
                'what_will_you_learn' => [
                    'Revise all high-yield Biology chapters in six focused weeks.',
                    'Memorise key tables, comparisons and diagrams with visual aids.',
                    'Drill past-paper MCQs chapter by chapter.',
                    'Fix the most common student mistakes in Biology MCQs.',
                    'Build a spaced-repetition routine for the last month.',
                    'Walk into the exam with a one-page final revision sheet.',
                ],
                'curriculum' => [
                    $this->module('Module 1: Cell Biology Sprint', [
                        $this->chapter('Chapter 1: Membranes & Transport', [
                            $this->topic('Membrane Transport in 20 Minutes', '20 min'),
                            $this->topic('Osmosis vs Diffusion MCQs', '18 min'),
                            $this->quizTopic('Membranes & Transport Quiz', 'biology', 0),
                        ]),
                        $this->chapter('Chapter 2: Enzymes & Metabolism', [
                            $this->topic('Enzyme Kinetics Speed Run', '22 min'),
                            $this->topic('Metabolism High-Yield Points', '20 min'),
                            $this->quizTopic('Enzymes & Metabolism Quiz', 'biology', 3),
                        ]),
                    ]),
                    $this->module('Module 2: Genetics Sprint', [
                        $this->chapter('Chapter 1: Mendelian Genetics', [
                            $this->topic('Mendelian Crosses Made Easy', '24 min'),
                            $this->topic('Pedigree Analysis Techniques', '22 min'),
                            $this->quizTopic('Mendelian Genetics Quiz', 'biology', 5),
                        ]),
                        $this->chapter('Chapter 2: Molecular Genetics', [
                            $this->topic('DNA Replication Quick Recap', '21 min'),
                            $this->topic('Transcription & Translation Recap', '23 min'),
                            $this->quizTopic('Molecular Genetics Quiz', 'biology', 9),
                        ]),
                    ]),
                    $this->module('Module 3: Physiology Sprint', [
                        $this->chapter('Chapter 1: Circulation & Respiration', [
                            $this->topic('Cardiac Cycle in 20 Minutes', '20 min'),
                            $this->topic('Gas Exchange Essentials', '19 min'),
                            $this->quizTopic('Circulation & Respiration Quiz', 'biology', 10),
                        ]),
                        $this->chapter('Chapter 2: Nervous & Endocrine', [
                            $this->topic('Nerve Impulse Rapid Recap', '21 min'),
                            $this->topic('Hormones Table Walkthrough', '18 min'),
                            $this->quizTopic('Nervous & Endocrine Quiz', 'biology', 12),
                        ]),
                    ]),
                ],
                'instructor_info' => [
                    'name' => 'Dr. Sana Yousaf',
                    'bio' => 'MBBS with a special interest in medical education. Known for turning dense Biology chapters into fast, memorable revision sessions.',
                    'courses' => '5+ Courses',
                    'students' => '7k+ Students',
                ],
                'success_stories' => [
                    ['name' => 'Zainab Ali', 'college' => 'Fatima Jinnah Medical University', 'selection' => 'MBBS', 'score' => '181/200', 'quote' => 'Six weeks was all I had left. The crash course told me exactly what to revise and what to skip.', 'proof_image' => 'frontend/img/proof/proof-1.png'],
                ],
            ]),

            $course([
                'slug' => 'chemistry-high-yield-crash-course',
                'title' => 'Chemistry High-Yield Crash Course',
                'category' => 'mdcat',
                'category_name' => 'MDCAT',
                'price' => 'Rs 4,500',
                'original_price' => 'Rs 7,000',
                'rating' => '4.8',
                'rating_count' => '860',
                'lessons' => '30 Lectures • 9 Quizzes',
                'students' => '1.1k+',
                'duration' => '5 Weeks',
                'level' => 'Intermediate',
                'instructor' => 'Dr. Hassan Raza',
                'success_badge' => 'MCQ Machine',
                'sort_order' => 5,
                'image' => 'frontend/img/course/course1-5.jpg',
                'detail_image' => 'frontend/img/course/course1-5.jpg',
                'overview' => 'Five weeks of pure Chemistry revision: physical chemistry numericals, organic mechanisms and inorganic trends trimmed down to what MDCAT actually asks. Includes a formula sheet, calculation shortcuts and chapter-wise MCQ drills.',
                'what_will_you_learn' => [
                    'Solve physical chemistry numericals with shortcut methods.',
                    'Master organic functional groups and named reactions.',
                    'Memorise periodic trends and inorganic exceptions.',
                    'Avoid the ten most common Chemistry MCQ traps.',
                    'Use a printable formula sheet during revision.',
                    'Finish with a timed Chemistry mock test.',
                ],
                'curriculum' => [
                    $this->module('Module 1: Physical Chemistry Sprint', [
                        $this->chapter('Chapter 1: Atomic Structure & Periodicity', [
                            $this->topic('Periodic Trends Speed Run', '22 min'),
                            $this->topic('Bonding and Hybridization Recap', '24 min'),
                            $this->quizTopic('Periodicity & Bonding Quiz', 'chemistry', 0),
                        ]),
                        $this->chapter('Chapter 2: Equilibrium & Kinetics', [
                            $this->topic('Equilibrium Shortcuts', '23 min'),
                            $this->topic('Rate Laws and Catalysis', '20 min'),
                            $this->quizTopic('Equilibrium & Kinetics Quiz', 'chemistry', 4),
                        ]),
                    ]),
                    $this->module('Module 2: Organic Chemistry Sprint', [
                        $this->chapter('Chapter 1: Functional Groups', [
                            $this->topic('Functional Group Identification', '21 min'),
                            $this->topic('Isomerism in 20 Minutes', '19 min'),
                            $this->quizTopic('Functional Groups Quiz', 'chemistry', 5),
                        ]),
                        $this->chapter('Chapter 2: Reactions & Mechanisms', [
                            $this->topic('Named Reactions Walkthrough', '24 min'),
                            $this->topic('Mechanism MCQ Techniques', '22 min'),
                            $this->quizTopic('Reactions & Mechanisms Quiz', 'chemistry', 9),
                        ]),
                    ]),
                    $this->module('Module 3: Inorganic Chemistry Sprint', [
                        $this->chapter('Chapter 1: s- and p-Block Essentials', [
                            $this->topic('s-Block High-Yield Facts', '20 min'),
                            $this->topic('p-Block High-Yield Facts', '21 min'),
                            $this->quizTopic('s- and p-Block Quiz', 'chemistry', 12),
                        ]),
                        $this->chapter('Chapter 2: Transition Metals', [
                            $this->topic('Transition Metal Properties', '22 min'),
                            $this->topic('Coordination Compounds Recap', '18 min'),
                            $this->quizTopic('Transition Metals Quiz', 'chemistry', 10),
                        ]),
                    ]),
                ],
                'instructor_info' => [
                    'name' => 'Dr. Hassan Raza',
                    'bio' => 'MPhil Chemistry with eight years of MDCAT coaching. Famous for calculation shortcuts that cut numerical time in half.',
                    'courses' => '4+ Courses',
                    'students' => '6k+ Students',
                ],
                'success_stories' => [
                    ['name' => 'Ali Hamza', 'college' => 'Allama Iqbal Medical College', 'selection' => 'MBBS', 'score' => '175/200', 'quote' => 'Chemistry was my weakest subject. The shortcut numericals actually made it my highest-scoring one.', 'proof_image' => 'frontend/img/proof/proof-2.png'],
                ],
            ]),
        ];
    }

    protected function module(string $name, array $chapters): array
    {
        return ['name' => $name, 'title' => $name, 'chapters' => $chapters];
    }

    protected function chapter(string $name, array $topics): array
    {
        return ['name' => $name, 'title' => $name, 'topics' => $topics];
    }

    protected function topic(string $title, string $duration): array
    {
        return ['title' => $title, 'type' => 'video', 'duration' => $duration];
    }

    protected function quizTopic(string $title, string $bank, int $offset): array
    {
        return [
            'title' => $title,
            'type' => 'quiz',
            'isQuiz' => true,
            'duration' => '5 min',
            'quizData' => [
                'title' => $title,
                'subtitle' => 'Single best answer MCQs with instant explanations.',
                'passingScore' => 70,
                'timeLimitMinutes' => 5,
                'questions' => $this->quizQuestions($bank, $offset, 5),
            ],
        ];
    }

    protected function quizQuestions(string $bank, int $offset, int $count): array
    {
        $pool = $this->questionBanks()[$bank];
        $out = [];
        for ($i = 0; $i < $count; $i++) {
            $q = $pool[($offset + $i) % count($pool)];
            $out[] = [
                'question' => $q['question'],
                'options' => $q['options'],
                'correctIndex' => ord($q['correct']) - 65,
                'explanation' => $q['explanation'],
            ];
        }

        return $out;
    }

    // ------------------------------------------------------------------
    // Mock tests
    // ------------------------------------------------------------------

    protected function seedMockTests(): void
    {
        if (! Schema::hasTable('mock_tests')) {
            return;
        }

        $banks = $this->questionBanks();
        $pick = fn (string $bank, array $idx) => array_map(fn ($i) => $banks[$bank][$i], $idx);

        $tests = [
            [
                'slug' => 'mdcat-grand-mock-2026',
                'title' => 'MDCAT Grand Mock Test 2026 — Full Syllabus',
                'category' => 'mdcat',
                'category_name' => 'MDCAT',
                'badge' => 'Full Syllabus',
                'duration_minutes' => 25,
                'passing_percentage' => 70,
                'difficulty' => 'Medium',
                'attempts' => '3.2k+',
                'image' => 'frontend/img/course/course1-1.jpg',
                'description' => 'A balanced full-syllabus mock covering Biology, Chemistry, Physics, English and Logical Reasoning. Fifteen carefully chosen MCQs that reflect the current paper difficulty.',
                'sort_order' => 1,
                'questions' => array_merge(
                    $pick('biology', [0, 1, 2, 3]),
                    $pick('chemistry', [0, 1, 2, 3]),
                    $pick('physics', [0, 1, 2, 3]),
                    $pick('english', [0, 1]),
                    $pick('logical', [0]),
                ),
            ],
            [
                'slug' => 'biology-cell-structure-mock',
                'title' => 'Biology Mock — Cell Structure & Function',
                'category' => 'mdcat',
                'category_name' => 'MDCAT',
                'badge' => 'Chapter Test',
                'duration_minutes' => 20,
                'passing_percentage' => 75,
                'difficulty' => 'Easy',
                'attempts' => '2.1k+',
                'image' => 'frontend/img/course/course1-4.jpg',
                'description' => 'Fifteen MCQs covering organelles, membranes, transport and cell division basics. Ideal for closing out the Biology cell chapter.',
                'sort_order' => 2,
                'questions' => $pick('biology', [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]),
            ],
            [
                'slug' => 'chemistry-organic-basics-mock',
                'title' => 'Chemistry Mock — Organic & Physical Basics',
                'category' => 'mdcat',
                'category_name' => 'MDCAT',
                'badge' => 'Chapter Test',
                'duration_minutes' => 20,
                'passing_percentage' => 70,
                'difficulty' => 'Medium',
                'attempts' => '1.8k+',
                'image' => 'frontend/img/course/course1-5.jpg',
                'description' => 'Fifteen MCQs blending physical chemistry fundamentals with organic chemistry basics — the exact mix students see in section tests.',
                'sort_order' => 3,
                'questions' => $pick('chemistry', [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]),
            ],
            [
                'slug' => 'physics-motion-force-mock',
                'title' => 'Physics Mock — Motion, Force & Energy',
                'category' => 'mdcat',
                'category_name' => 'MDCAT',
                'badge' => 'Chapter Test',
                'duration_minutes' => 20,
                'passing_percentage' => 70,
                'difficulty' => 'Medium',
                'attempts' => '1.6k+',
                'image' => 'frontend/img/course/course1-3.jpg',
                'description' => 'Fifteen mechanics and electricity MCQ drills covering motion, Newton\'s laws, work, energy, power and current electricity.',
                'sort_order' => 4,
                'questions' => $pick('physics', [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]),
            ],
            [
                'slug' => 'nums-mixed-practice-mock',
                'title' => 'NUMS Practice Mock — Mixed Subjects',
                'category' => 'nums',
                'category_name' => 'NUMS',
                'badge' => 'NUMS Pattern',
                'duration_minutes' => 25,
                'passing_percentage' => 70,
                'difficulty' => 'Hard',
                'attempts' => '1.3k+',
                'image' => 'frontend/img/course/course1-2.jpg',
                'description' => 'A NUMS-style mixed mock with Biology, Chemistry, Physics, English and reasoning items distributed like the actual paper.',
                'sort_order' => 5,
                'questions' => array_merge(
                    $pick('biology', [4, 5, 6, 7, 8]),
                    $pick('chemistry', [4, 5, 6, 7]),
                    $pick('physics', [4, 5, 6]),
                    $pick('english', [2, 3]),
                    $pick('logical', [1]),
                ),
            ],
        ];

        foreach ($tests as $config) {
            $questions = $config['questions'];
            unset($config['questions']);

            $test = MockTest::updateOrCreate(
                ['slug' => $config['slug']],
                array_merge($config, [
                    'total_questions' => count($questions),
                    'marks_per_question' => 1,
                    'is_active' => true,
                ])
            );

            MockTestQuestion::where('mock_test_id', $test->id)->delete();

            foreach ($questions as $order => $q) {
                MockTestQuestion::create([
                    'mock_test_id' => $test->id,
                    'subject' => $q['subject'],
                    'question' => $q['question'],
                    'options' => $q['options'],
                    'correct_option' => $q['correct'],
                    'explanation' => $q['explanation'],
                    'sort_order' => $order + 1,
                    'is_active' => true,
                ]);
            }
        }
    }

    // ------------------------------------------------------------------
    // E-library
    // ------------------------------------------------------------------

    protected function seedResources(): void
    {
        if (! Schema::hasTable('elibrary_resources')) {
            return;
        }

        $resources = [
            [
                'slug' => 'mdcat-biology-quick-revision-notes',
                'title' => 'MDCAT Biology Quick Revision Notes',
                'category' => 'notes',
                'exam_category' => 'mdcat',
                'category_name' => 'MDCAT',
                'subject' => 'Biology',
                'badge' => 'High Yield',
                'format' => 'PDF',
                'pages' => '48 Pages',
                'size' => '1.9 MB',
                'downloads' => 2450,
                'rating' => '4.9',
                'image' => 'frontend/img/course/course1-1.jpg',
                'description' => 'Chapter-wise condensed notes covering the highest-yield Biology facts, tables and diagrams for quick revision before the exam.',
                'file_name' => 'MDCAT-Biology-Quick-Revision-Notes.pdf',
                'file_path' => 'frontend/files/elibrary/mdcat-biology-quick-revision-notes.pdf',
                'sort_order' => 1,
            ],
            [
                'slug' => 'mdcat-past-paper-2025-solved',
                'title' => 'MDCAT 2025 Past Paper — Solved',
                'category' => 'past-papers',
                'exam_category' => 'mdcat',
                'category_name' => 'MDCAT',
                'subject' => 'All Subjects',
                'badge' => 'Solved Paper',
                'format' => 'PDF',
                'pages' => '36 Pages',
                'size' => '1.4 MB',
                'downloads' => 3120,
                'rating' => '4.8',
                'image' => 'frontend/img/course/course1-2.jpg',
                'description' => 'The complete MDCAT 2025 paper reproduced with worked solutions, answer keys and difficulty analysis for every section.',
                'file_name' => 'MDCAT-2025-Past-Paper-Solved.pdf',
                'file_path' => 'frontend/files/elibrary/mdcat-past-paper-2025-solved.pdf',
                'sort_order' => 2,
            ],
            [
                'slug' => 'mdcat-chemistry-formula-sheet',
                'title' => 'MDCAT Chemistry Formula Sheet',
                'category' => 'notes',
                'exam_category' => 'mdcat',
                'category_name' => 'MDCAT',
                'subject' => 'Chemistry',
                'badge' => 'Print & Revise',
                'format' => 'PDF',
                'pages' => '12 Pages',
                'size' => '0.8 MB',
                'downloads' => 1980,
                'rating' => '4.9',
                'image' => 'frontend/img/course/course1-5.jpg',
                'description' => 'Every formula, constant and calculation shortcut used in MDCAT Chemistry, printed as a compact daily revision sheet.',
                'file_name' => 'MDCAT-Chemistry-Formula-Sheet.pdf',
                'file_path' => 'frontend/files/elibrary/mdcat-chemistry-formula-sheet.pdf',
                'sort_order' => 3,
            ],
            [
                'slug' => 'amc-army-entry-test-guide',
                'title' => 'AMC / Army Entry Test Complete Guide',
                'category' => 'army',
                'exam_category' => 'army',
                'category_name' => 'Army / AMC',
                'subject' => 'All Subjects',
                'badge' => 'Selection Guide',
                'format' => 'PDF',
                'pages' => '24 Pages',
                'size' => '1.1 MB',
                'downloads' => 1240,
                'rating' => '4.7',
                'image' => 'frontend/img/course/course1-3.jpg',
                'description' => 'Eligibility, test pattern, ISSB overview and a 30-day preparation plan for the Army Medical Corps selection process.',
                'file_name' => 'AMC-Army-Entry-Test-Guide.pdf',
                'file_path' => 'frontend/files/elibrary/amc-army-entry-test-guide.pdf',
                'sort_order' => 4,
            ],
            [
                'slug' => 'nums-practice-mcq-bank-2026',
                'title' => 'NUMS Practice MCQ Bank 2026',
                'category' => 'nums',
                'exam_category' => 'nums',
                'category_name' => 'NUMS',
                'subject' => 'All Subjects',
                'badge' => 'Practice Set',
                'format' => 'PDF',
                'pages' => '30 Pages',
                'size' => '1.2 MB',
                'downloads' => 1670,
                'rating' => '4.8',
                'image' => 'frontend/img/course/course1-4.jpg',
                'description' => 'Subject-wise NUMS practice MCQs with explained answers covering Biology, Chemistry, Physics, English and Logical Reasoning.',
                'file_name' => 'NUMS-Practice-MCQ-Bank-2026.pdf',
                'file_path' => 'frontend/files/elibrary/nums-practice-mcq-bank-2026.pdf',
                'sort_order' => 5,
            ],
        ];

        foreach ($resources as $resource) {
            ElibraryResource::updateOrCreate(
                ['slug' => $resource['slug']],
                array_merge($resource, ['is_active' => true])
            );
        }
    }

    // ------------------------------------------------------------------
    // Question banks
    // ------------------------------------------------------------------

    protected function questionBanks(): array
    {
        static $banks = null;
        if ($banks !== null) {
            return $banks;
        }

        $q = fn (string $subject, string $question, array $options, string $correct, string $explanation) => compact('subject', 'question', 'options', 'correct', 'explanation');

        $banks = [
            'biology' => [
                $q('Biology', 'Which organelle is known as the powerhouse of the cell?', ['Mitochondrion', 'Ribosome', 'Golgi apparatus', 'Lysosome'], 'A', 'Mitochondria generate most of the cell ATP through oxidative phosphorylation inside the inner membrane.'),
                $q('Biology', 'Where does protein synthesis take place in a cell?', ['Ribosome', 'Nucleolus', 'Smooth endoplasmic reticulum', 'Centriole'], 'A', 'Ribosomes are the site of translation, where mRNA is decoded into polypeptide chains.'),
                $q('Biology', 'Which organelle contains hydrolytic enzymes used for intracellular digestion?', ['Lysosome', 'Peroxisome', 'Smooth endoplasmic reticulum', 'Mitochondrion'], 'A', 'Lysosomes are membrane-bound sacs of acid hydrolases that digest worn-out organelles and engulfed material.'),
                $q('Biology', 'In which phase of the cell cycle is DNA replicated?', ['S phase', 'G1 phase', 'G2 phase', 'M phase'], 'A', 'DNA synthesis (replication) occurs during the S phase of interphase.'),
                $q('Biology', 'What is the normal number of chromosomes in a human somatic cell?', ['46', '23', '44', '48'], 'A', 'Human somatic cells are diploid with 23 pairs, totalling 46 chromosomes.'),
                $q('Biology', 'Which cells are the most abundant phagocytes during acute inflammation?', ['Neutrophils', 'Lymphocytes', 'Erythrocytes', 'Platelets'], 'A', 'Neutrophils are the first leukocytes to arrive at an acute inflammatory site and dominate phagocytosis there.'),
                $q('Biology', 'Which enzyme unwinds the DNA double helix ahead of the replication fork?', ['DNA helicase', 'DNA polymerase', 'DNA ligase', 'Primase'], 'A', 'Helicase breaks hydrogen bonds between base pairs to separate the two parental strands.'),
                $q('Biology', 'Deficiency of which vitamin causes night blindness?', ['Vitamin A', 'Vitamin B12', 'Vitamin C', 'Vitamin D'], 'A', 'Vitamin A is required to form rhodopsin, the visual pigment of rod cells that supports vision in dim light.'),
                $q('Biology', 'During strenuous exercise, rising CO2 shifts the oxygen dissociation curve to the right. What is this called?', ['Bohr effect', 'Haldane effect', 'Starling law', 'Frank-Starling mechanism'], 'A', 'The Bohr effect is the rightward shift of the oxygen-haemoglobin curve caused by increased CO2 and H+ ions, improving oxygen unloading at tissues.'),
                $q('Biology', 'What is the functional unit of the kidney?', ['Nephron', 'Neuron', 'Alveolus', 'Hepatocyte'], 'A', 'Each kidney contains about a million nephrons, the structural and functional units that filter blood and form urine.'),
                $q('Biology', 'Which hormone lowers blood glucose concentration?', ['Insulin', 'Glucagon', 'Cortisol', 'Adrenaline'], 'A', 'Insulin promotes cellular uptake of glucose and glycogenesis, thereby lowering blood glucose.'),
                $q('Biology', 'Which type of cell division halves the chromosome number?', ['Meiosis', 'Mitosis', 'Amitosis', 'Binary fission'], 'A', 'Meiosis produces four haploid cells, reducing the chromosome number from diploid to haploid.'),
                $q('Biology', 'Which blood group is the universal donor for packed red cells?', ['O negative', 'AB positive', 'A positive', 'B negative'], 'A', 'O negative red cells lack A, B and Rh D antigens, so they can be transfused to recipients of any group.'),
                $q('Biology', 'Movement of water across a semipermeable membrane towards higher solute concentration is called:', ['Osmosis', 'Diffusion', 'Active transport', 'Phagocytosis'], 'A', 'Osmosis is the passive movement of water down its own concentration gradient across a selectively permeable membrane.'),
                $q('Biology', 'ATP synthase of the mitochondrion is located in the:', ['Inner mitochondrial membrane', 'Outer mitochondrial membrane', 'Mitochondrial matrix', 'Intermembrane space'], 'A', 'The F0F1 ATP synthase complex is embedded in the inner mitochondrial membrane, where the proton gradient drives ATP synthesis.'),
            ],
            'chemistry' => [
                $q('Chemistry', 'What is the pH of pure water at 25 C?', ['7', '0', '14', '1'], 'A', 'At 25 C, pure water ionises to give equal concentrations of H+ and OH- ions, so pH = 7.'),
                $q('Chemistry', 'Which of the following is a noble gas?', ['Argon', 'Nitrogen', 'Chlorine', 'Hydrogen'], 'A', 'Argon belongs to Group 18 and has a complete valence shell, making it chemically inert.'),
                $q('Chemistry', 'What is the hybridization of carbon in methane?', ['sp3', 'sp2', 'sp', 'sp3d'], 'A', 'The carbon atom in methane forms four sigma bonds with tetrahedral geometry, requiring sp3 hybridization.'),
                $q('Chemistry', 'What is the oxidation state of manganese in KMnO4?', ['+7', '+6', '+4', '+2'], 'A', 'With K as +1 and each oxygen as -2, manganese must be +7 for the compound to be neutral.'),
                $q('Chemistry', 'Which functional group is present in carboxylic acids?', ['-COOH', '-OH', '-CHO', '-NH2'], 'A', 'Carboxylic acids contain the carboxyl group -COOH, combining a carbonyl and a hydroxyl group.'),
                $q('Chemistry', 'What is the value of Avogadro number?', ['6.022 x 10^23', '6.022 x 10^22', '3.14 x 10^23', '9.8 x 10^23'], 'A', 'One mole of any substance contains 6.022 x 10^23 particles.'),
                $q('Chemistry', 'Which isotope of hydrogen contains two neutrons?', ['Tritium', 'Deuterium', 'Protium', 'Hydride'], 'A', 'Tritium has one proton and two neutrons, giving it a mass number of 3.'),
                $q('Chemistry', 'What is the molar mass of carbon dioxide?', ['44 g/mol', '28 g/mol', '32 g/mol', '12 g/mol'], 'A', 'CO2 contains 12 g of carbon and 32 g of oxygen, totalling 44 g/mol.'),
                $q('Chemistry', 'How does a catalyst increase the rate of a reaction?', ['It lowers the activation energy', 'It increases the heat released', 'It raises the activation energy', 'It changes the enthalpy of reaction'], 'A', 'A catalyst provides an alternative pathway with lower activation energy, so more collisions are effective.'),
                $q('Chemistry', 'What is the IUPAC name of CH3CH2OH?', ['Ethanol', 'Methanol', 'Ethanal', 'Ethanoic acid'], 'A', 'A two-carbon chain bearing a hydroxyl group is named ethanol.'),
                $q('Chemistry', 'Enantiomers are best described as:', ['Non-superimposable mirror images', 'Structurally identical molecules', 'Constitutional isomers', 'Cis-trans isomers'], 'A', 'Enantiomers are chiral molecules that are mirror images yet cannot be superimposed on each other.'),
                $q('Chemistry', 'Which factor does NOT affect the rate of a chemical reaction?', ['Colour of the reaction vessel', 'Temperature', 'Concentration of reactants', 'Presence of a catalyst'], 'A', 'Reaction rate depends on concentration, temperature, surface area and catalysts, not on the vessel colour.'),
                $q('Chemistry', 'Which is the most electronegative element?', ['Fluorine', 'Oxygen', 'Chlorine', 'Nitrogen'], 'A', 'Fluorine has the highest electronegativity on the Pauling scale (4.0).'),
                $q('Chemistry', 'Increasing pressure shifts a gaseous equilibrium towards the side with:', ['Fewer moles of gas', 'More moles of gas', 'The reactants always', 'No net change'], 'A', 'Le Chatelier principle predicts a shift towards fewer gaseous moles to relieve increased pressure.'),
                $q('Chemistry', 'Which of the following is a saturated hydrocarbon?', ['Ethane', 'Ethene', 'Ethyne', 'Benzene'], 'A', 'Ethane contains only single carbon-carbon bonds, making it saturated.'),
            ],
            'physics' => [
                $q('Physics', 'What is the SI unit of force?', ['Newton', 'Joule', 'Watt', 'Pascal'], 'A', 'One newton is the force needed to accelerate 1 kg at 1 m/s².'),
                $q('Physics', 'Which equation expresses Newton second law of motion?', ['F = ma', 'F = mv', 'F = mgh', 'F = mv²/2'], 'A', 'Force equals mass times acceleration, a vector relationship that defines inertia and dynamics.'),
                $q('Physics', 'What is the approximate acceleration due to gravity near Earth surface?', ['9.8 m/s²', '6.7 m/s²', '3.0 x 10^8 m/s', '1.6 m/s²'], 'A', 'Near Earth surface the free-fall acceleration is about 9.8 m/s² downward.'),
                $q('Physics', 'How much work is done when force is perpendicular to displacement?', ['Zero', 'Maximum', 'Negative', 'Equal to the force'], 'A', 'Work is F d cos(theta); with theta = 90 degrees, cos 90 = 0, so the work done is zero.'),
                $q('Physics', 'The kinetic energy of a moving body is given by:', ['Half mv squared', 'mv', 'mgh', 'mv cubed'], 'A', 'Kinetic energy equals 1/2 mv², deriving from the work-energy theorem.'),
                $q('Physics', 'What is the SI unit of power?', ['Watt', 'Joule', 'Newton', 'Hertz'], 'A', 'Power is work per unit time, measured in watts where 1 W = 1 J/s.'),
                $q('Physics', 'Ohm law is expressed as:', ['V = IR', 'V = I/R', 'V = R/I', 'V = I²R'], 'A', 'At constant temperature, potential difference is directly proportional to current, giving V = IR.'),
                $q('Physics', 'Two resistors of 2 ohm and 3 ohm are connected in series. What is the equivalent resistance?', ['5 ohm', '1.2 ohm', '6 ohm', '0.83 ohm'], 'A', 'Series resistances add directly: 2 + 3 = 5 ohm.'),
                $q('Physics', 'What is the speed of light in vacuum?', ['3 x 10^8 m/s', '3 x 10^6 m/s', '3 x 10^10 m/s', '340 m/s'], 'A', 'Light travels at approximately 3 x 10^8 m/s in vacuum, the universal speed limit.'),
                $q('Physics', 'Momentum of a body is given by:', ['p = mv', 'p = ma', 'p = mv²', 'p = mgh'], 'A', 'Linear momentum is the product of mass and velocity, p = mv.'),
                $q('Physics', 'Hooke law within the elastic limit states that extension is:', ['Directly proportional to applied force', 'Inversely proportional to applied force', 'Independent of the applied force', 'Proportional to the square of the force'], 'A', 'Within the elastic limit, extension is directly proportional to the load, F = kx.'),
                $q('Physics', 'What is the SI unit of frequency?', ['Hertz', 'Second', 'Radian', 'Watt'], 'A', 'Frequency is cycles per second, measured in hertz (Hz).'),
                $q('Physics', 'Which liquid has the highest specific heat capacity?', ['Water', 'Mercury', 'Alcohol', 'Kerosene'], 'A', 'Water has an unusually high specific heat capacity (about 4186 J/kg K), making it an excellent coolant.'),
                $q('Physics', 'A body falling freely under gravity (ignoring air resistance) moves with:', ['Constant acceleration', 'Constant velocity', 'Constant speed', 'Zero acceleration'], 'A', 'Gravity provides a constant downward acceleration of about 9.8 m/s² near Earth surface.'),
                $q('Physics', 'Lenz law determines the:', ['Direction of induced EMF', 'Magnitude of induced EMF', 'Resistance of the coil', 'Magnetic flux density'], 'A', 'Lenz law states that induced current opposes the change producing it, giving the direction of the induced EMF.'),
            ],
            'english' => [
                $q('English', 'Choose the correct synonym of abundant.', ['Plentiful', 'Scarce', 'Rare', 'Limited'], 'A', 'Abundant means available in large quantities, that is, plentiful.'),
                $q('English', 'Choose the antonym of significant.', ['Trivial', 'Important', 'Notable', 'Meaningful'], 'A', 'Significant means important; its opposite is trivial or insignificant.'),
                $q('English', 'Choose the correctly spelt word.', ['Accommodate', 'Acommodate', 'Accommadate', 'Accomodate'], 'A', 'Accommodate is spelt with double c and double m.'),
                $q('English', 'Fill in the blank: Neither of the students ___ present in class.', ['was', 'were', 'are', 'have'], 'A', 'Neither is singular, so it takes the singular verb was.'),
                $q('English', 'Fill in the blank: The number of applicants ___ increasing every year.', ['is', 'are', 'have', 'were'], 'A', 'The subject is the number, which is singular, so the verb is is.'),
                $q('English', 'What does meticulous mean?', ['Extremely careful about details', 'Careless and hasty', 'Quick and unprepared', 'Lazy and indifferent'], 'A', 'Meticulous describes someone who shows great attention to detail.'),
            ],
            'logical' => [
                $q('Logical Reasoning', 'Complete the series: 2, 6, 12, 20, 30, ?', ['42', '40', '36', '44'], 'A', 'Differences increase by 2 each time (4, 6, 8, 10, 12), so 30 + 12 = 42.'),
                $q('Logical Reasoning', 'Which number does not belong: 3, 5, 7, 9, 11?', ['9', '3', '7', '11'], 'A', 'All numbers except 9 are prime; 9 is the only composite number in the list.'),
                $q('Logical Reasoning', 'A is north of B and B is east of C. A is in which direction from C?', ['North-east', 'North-west', 'South-east', 'South-west'], 'A', 'Moving east from C to B and then north to A places A to the north-east of C.'),
                $q('Logical Reasoning', 'All doctors are educated. Some educated people are famous. Which conclusion follows?', ['Some doctors may be famous', 'All doctors are famous', 'No doctor is famous', 'Some educated people are doctors'], 'A', 'Only a possibility follows: doctors, being educated, may fall among the famous educated people.'),
                $q('Logical Reasoning', 'What is the angle between the clock hands at exactly 3:00?', ['90 degrees', '180 degrees', '45 degrees', '120 degrees'], 'A', 'At 3:00 the hour hand points at 3 and the minute hand at 12, a quarter turn apart, that is 90 degrees.'),
            ],
        ];

        return $banks;
    }
}
