<?php

namespace App\Jobs;

use App\Models\LectureVideo;
use App\Services\VideoProcessingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class ProcessLectureVideoJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 2;

    public int $timeout = 3600;

    public int $backoff = 60;

    public bool $failOnTimeout = true;

    public function __construct(public LectureVideo $video)
    {
    }

    public function uniqueId(): string
    {
        return 'lecture-video-' . $this->video->id;
    }

    public function handle(VideoProcessingService $processor): void
    {
        $video = $this->video->fresh();
        if (! $video) {
            return;
        }

        if ($video->status === 'ready' && $video->hls_path) {
            return;
        }

        $video->forceFill([
            'status' => 'processing',
            'progress' => 1,
            'error_message' => null,
            'processing_started_at' => now(),
        ])->save();

        try {
            $processor->process($video, function (int $percent) use ($video) {
                $video->forceFill(['progress' => $percent])->saveQuietly();
            });
        } catch (Throwable $e) {
            $video->forceFill([
                'status' => 'failed',
                'error_message' => Str::limit($e->getMessage(), 900),
            ])->save();

            Log::error('Lecture video processing failed', [
                'lecture_video_id' => $video->id,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    public function failed(?Throwable $e): void
    {
        $video = LectureVideo::find($this->video->id);
        if (! $video) {
            return;
        }

        $video->forceFill([
            'status' => 'failed',
            'error_message' => Str::limit($e ? $e->getMessage() : 'Processing failed.', 900),
        ])->save();

        // Remove any partial HLS output so it can never be served.
        try {
            \Illuminate\Support\Facades\Storage::disk(LectureVideo::diskName())
                ->deleteDirectory($video->hls_path ?: 'hls/' . $video->id);
        } catch (Throwable $ignored) {
            // best effort cleanup
        }
    }
}
