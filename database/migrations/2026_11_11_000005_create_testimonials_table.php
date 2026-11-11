<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('headline', 255);
            $table->text('quote');
            $table->string('student_name', 120);
            $table->string('student_batch', 150)->nullable();
            $table->string('avatar', 255)->nullable();
            $table->string('rating', 10)->default('5.0');
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'sort_order'], 'idx_testimonials_active_sort');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
