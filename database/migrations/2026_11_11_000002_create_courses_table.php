<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 150)->unique();
            $table->string('category', 50)->default('mdcat');
            $table->string('category_name', 80)->default('MDCAT');
            $table->string('title', 255);
            $table->string('price', 60)->default('Free');
            $table->string('original_price', 60)->nullable();
            $table->string('rating', 16)->default('4.9');
            $table->string('rating_count', 32)->default('1k');
            $table->string('lessons', 60)->nullable();
            $table->string('students', 60)->nullable();
            $table->string('duration', 60)->nullable();
            $table->string('level', 80)->nullable();
            $table->string('language', 80)->nullable();
            $table->string('instructor', 120)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('detail_image', 255)->nullable();
            $table->string('instructor_image', 255)->nullable();
            $table->string('success_badge', 120)->nullable();
            $table->longText('overview')->nullable();
            $table->json('what_will_you_learn')->nullable();
            $table->json('curriculum')->nullable();
            $table->json('instructor_info')->nullable();
            $table->json('success_stories')->nullable();
            $table->json('reviews')->nullable();
            $table->boolean('is_featured')->default(true);
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'is_featured', 'sort_order'], 'idx_courses_home_listing');
            $table->index(['is_active', 'category', 'sort_order'], 'idx_courses_cat_sort');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
