<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 160)->unique();
            $table->string('title', 255);
            $table->string('category', 80)->default('MDCAT Preparation');
            $table->text('short_description')->nullable();
            $table->longText('content')->nullable();
            $table->string('image', 255)->nullable();
            $table->json('author')->nullable();
            $table->json('tags')->nullable();
            $table->string('read_time', 40)->default('5 min read');
            $table->string('date_day', 10)->nullable();
            $table->string('date_month', 20)->nullable();
            $table->string('date_year', 10)->nullable();
            $table->boolean('is_published')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_published', 'sort_order', 'created_at'], 'idx_blogs_home_recent');
            $table->index(['is_published', 'category'], 'idx_blogs_category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
