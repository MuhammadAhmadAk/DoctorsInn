<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Executive Administrator
        User::updateOrCreate(
            ['email' => 'admin@doctorsinn.pk'],
            [
                'name' => 'Dr. M. Ahmad',
                'phone' => '+92 300 1234567',
                'role' => 'admin',
                'avatar' => 'frontend/img/team/team_2_1.jpg',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Demo Student Account
        User::updateOrCreate(
            ['email' => 'student@doctorsinn.pk'],
            [
                'name' => 'MDCAT Aspirant',
                'phone' => '+92 312 9876543',
                'role' => 'student',
                'avatar' => 'frontend/img/testimonial/testi_2_1.png',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]
        );

        // 3. Complete Website CMS, Courses, Blogs, Mock Tests, E-Library, Faculty, Testimonials & FAQs
        $this->call(SiteCmsSeeder::class);
    }
}
