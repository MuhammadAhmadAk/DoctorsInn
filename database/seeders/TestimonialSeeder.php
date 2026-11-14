<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'student_name' => 'Ayesha Siddiqui',
                'student_batch' => 'MDCAT 2025 · 94%',
                'headline' => 'From 62% to 94% in one attempt',
                'quote' => 'DoctorsInn ki topic-wise lectures ne meri weakest subjects ko sab se strong bana diya. Week 6 ke mock tests ne meri timing aur accuracy dono improve ki — MDCAT mein 94% liye.',
                'avatar' => 'frontend/img/testimonial/testi_2_1.png',
                'rating' => '5.0',
                'sort_order' => 1,
            ],
            [
                'student_name' => 'Hamza Tariq',
                'student_batch' => 'NUMS 2025 · 1st Attempt',
                'headline' => 'Best decision of my gap year',
                'quote' => 'Sir ki explanation itni simple thi ke Bio ke complex pathways bhi board se zyada clear ho gaye. Daily quizzes aur detailed explanations ne confidence build kiya — pehle hi attempt mein NUMS clear kar liya.',
                'avatar' => 'frontend/img/testimonial/testi_2_2.png',
                'rating' => '5.0',
                'sort_order' => 2,
            ],
            [
                'student_name' => 'Zainab Fatima',
                'student_batch' => 'AMC Part 1 · 2025',
                'headline' => 'AMC ke liye perfect structured prep',
                'quote' => 'Job ke saath prep karna mushkil tha, lekin recorded lectures aur flexible mock tests ki wajah se schedule manage ho gaya. AMC Part 1 mein comfortable score aya.',
                'avatar' => 'frontend/img/testimonial/testi_2_3.png',
                'rating' => '4.9',
                'sort_order' => 3,
            ],
            [
                'student_name' => 'Bilal Ahmed',
                'student_batch' => 'MDCAT 2024 · Repeater',
                'headline' => 'Repeater ke liye game changer',
                'quote' => 'Pehli dafa self-study se MDCAT miss hua tha. Yahan har lecture ke baad quiz aur monthly test ne kamzoriyan exactly point out kar di. Dobara attempt mein merit list mein aa gaya.',
                'avatar' => 'frontend/img/testimonial/testi_2_2.png',
                'rating' => '5.0',
                'sort_order' => 4,
            ],
            [
                'student_name' => 'Maryam Noor',
                'student_batch' => 'NUMS 2025 · 88%',
                'headline' => 'Mock tests ne timing fix ki',
                'quote' => 'Shuru mein sirf 90 questions attempt kar pati thi. Weekly full-length mocks aur performance review ke baad 180+ questions attempt karna normal ban gaya. NUMS mein 88% mile.',
                'avatar' => 'frontend/img/testimonial/testi_2_1.png',
                'rating' => '4.8',
                'sort_order' => 5,
            ],
            [
                'student_name' => 'Usman Raza',
                'student_batch' => 'MDCAT 2025 · 91%',
                'headline' => 'Teachers ki availability sab se bari plus',
                'quote' => 'Doubt poochne ke liye wait nahi karna parta — har doubt ka reply jaldi milta hai. Physics ke numericals yahin se solve hue, aur akhir mein MDCAT mein 91% aaye.',
                'avatar' => 'frontend/img/testimonial/testi_2_3.png',
                'rating' => '5.0',
                'sort_order' => 6,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::updateOrCreate(
                ['student_name' => $testimonial['student_name']],
                $testimonial + ['is_active' => true]
            );
        }
    }
}
