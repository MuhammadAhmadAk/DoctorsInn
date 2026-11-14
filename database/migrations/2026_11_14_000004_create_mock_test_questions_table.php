<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('mock_test_questions')) {
            return;
        }

        Schema::create('mock_test_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mock_test_id')->constrained('mock_tests')->cascadeOnDelete();
            $table->string('subject', 80)->default('General');
            $table->text('question');
            $table->json('options');
            $table->char('correct_option', 1)->default('A');
            $table->text('explanation')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['mock_test_id', 'sort_order'], 'idx_mtq_test_sort');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mock_test_questions');
    }
};
