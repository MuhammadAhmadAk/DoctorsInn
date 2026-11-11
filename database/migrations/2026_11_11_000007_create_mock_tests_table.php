<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mock_tests', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 160)->unique();
            $table->string('title', 255);
            $table->string('category', 50)->default('mdcat');
            $table->string('category_name', 80)->default('MDCAT');
            $table->string('badge', 60)->nullable();
            $table->unsignedSmallInteger('duration_minutes')->default(30);
            $table->unsignedSmallInteger('total_questions')->default(10);
            $table->unsignedTinyInteger('marks_per_question')->default(1);
            $table->unsignedTinyInteger('passing_percentage')->default(70);
            $table->string('difficulty', 30)->default('Medium');
            $table->string('attempts', 30)->default('1k+');
            $table->string('image', 255)->nullable();
            $table->text('description')->nullable();
            $table->json('questions')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'category', 'sort_order'], 'idx_mock_tests_cat_sort');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mock_tests');
    }
};
