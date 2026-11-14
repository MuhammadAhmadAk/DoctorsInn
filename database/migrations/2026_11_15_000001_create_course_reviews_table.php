<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('course_reviews')) {
            Schema::create('course_reviews', function (Blueprint $table) {
                $table->id();
                $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('name', 120);
                $table->string('email', 150)->nullable();
                $table->unsignedTinyInteger('rating')->default(5);
                $table->text('comment');
                $table->string('status', 30)->default('approved');
                $table->timestamps();

                $table->index(['course_id', 'status', 'created_at'], 'idx_course_reviews_lookup');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('course_reviews');
    }
};
