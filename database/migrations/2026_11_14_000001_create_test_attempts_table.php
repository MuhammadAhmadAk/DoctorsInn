<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('mock_test_id')->nullable()->constrained('mock_tests')->nullOnDelete();
            $table->string('test_slug', 160);
            $table->string('test_title', 255);
            $table->string('test_category_name', 80)->default('MDCAT');
            $table->unsignedTinyInteger('marks_per_question')->default(1);
            $table->unsignedSmallInteger('total_questions')->default(0);
            $table->unsignedSmallInteger('correct_count')->default(0);
            $table->unsignedSmallInteger('incorrect_count')->default(0);
            $table->unsignedSmallInteger('skipped_count')->default(0);
            $table->unsignedSmallInteger('score')->default(0);
            $table->unsignedSmallInteger('total_marks')->default(0);
            $table->decimal('percentage', 5, 2)->default(0);
            $table->boolean('passed')->default(false);
            $table->unsignedTinyInteger('passing_percentage')->default(70);
            $table->unsignedInteger('time_spent_seconds')->default(0);
            $table->json('breakdown')->nullable();
            $table->json('subject_stats')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_attempts');
    }
};
