<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('elibrary_resources', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 160)->unique();
            $table->string('title', 255);
            $table->string('category', 60)->default('mdcat');
            $table->string('exam_category', 60)->default('mdcat');
            $table->string('category_name', 80)->default('MDCAT');
            $table->string('subject', 80)->default('All Subjects');
            $table->string('badge', 60)->nullable();
            $table->string('format', 20)->default('PDF');
            $table->string('pages', 40)->default('50 Pages');
            $table->string('size', 40)->default('3.5 MB');
            $table->string('downloads', 30)->default('1.2k+');
            $table->string('rating', 12)->default('4.9');
            $table->string('image', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('file_name', 255)->nullable();
            $table->string('file_path', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'category', 'sort_order'], 'idx_elibrary_cat_sort');
            $table->index(['is_active', 'exam_category'], 'idx_elibrary_exam_cat');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('elibrary_resources');
    }
};
