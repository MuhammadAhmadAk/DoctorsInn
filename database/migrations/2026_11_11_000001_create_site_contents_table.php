<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_contents', function (Blueprint $table) {
            $table->id();
            $table->string('section', 60);
            $table->string('key', 100)->unique();
            $table->string('label', 150);
            $table->string('type', 30)->default('text'); // text, textarea, image, url, number
            $table->longText('value')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['section', 'sort_order'], 'idx_site_contents_section_sort');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_contents');
    }
};
