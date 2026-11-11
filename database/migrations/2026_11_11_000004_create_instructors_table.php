<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('designation', 120)->default('Instructor');
            $table->text('bio')->nullable();
            $table->string('image', 255)->nullable();
            $table->string('rating', 12)->default('4.9');
            $table->string('facebook_url', 255)->nullable();
            $table->string('twitter_url', 255)->nullable();
            $table->string('linkedin_url', 255)->nullable();
            $table->string('instagram_url', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'sort_order'], 'idx_instructors_active_sort');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instructors');
    }
};
