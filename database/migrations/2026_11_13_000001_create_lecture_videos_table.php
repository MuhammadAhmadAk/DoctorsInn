<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lecture_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->nullable()->constrained('courses')->nullOnDelete();
            $table->string('topic_id', 191)->nullable();
            $table->string('title', 255);
            $table->string('original_filename', 255)->nullable();
            $table->string('original_path', 500);
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('size_bytes')->nullable();

            // queued | processing | ready | failed
            $table->string('status', 20)->default('queued');
            $table->unsignedTinyInteger('progress')->default(0);
            $table->text('error_message')->nullable();

            $table->unsignedInteger('duration_seconds')->nullable();
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();

            // { "360p": { "height": 360, "width": 640, "bandwidth": 896000 }, ... }
            $table->json('qualities')->nullable();

            $table->string('hls_path', 500)->nullable();
            $table->string('master_playlist', 120)->default('master.m3u8');

            $table->timestamp('processing_started_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            $table->index(['course_id', 'status'], 'idx_lecture_videos_course_status');
            $table->index(['topic_id', 'status'], 'idx_lecture_videos_topic_status');
            $table->index('status', 'idx_lecture_videos_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lecture_videos');
    }
};
