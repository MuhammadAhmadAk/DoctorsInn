<?php

namespace App\Console\Commands;

use App\Jobs\ProcessLectureVideoJob;
use App\Models\LectureVideo;
use App\Services\VideoProcessingService;
use Illuminate\Console\Command;
use Throwable;

class ProcessLectureCommand extends Command
{
    protected $signature = 'lectures:process {video : Lecture video ID}';

    protected $description = 'Transcode one lecture video into adaptive HLS in a standalone process.';

    public function handle(VideoProcessingService $processor): int
    {
        $video = LectureVideo::find($this->argument('video'));

        if (! $video) {
            $this->error('Lecture video not found.');

            return self::FAILURE;
        }

        if ($video->status === 'ready' && $video->hls_path) {
            $this->info('Lecture is already processed.');

            return self::SUCCESS;
        }

        try {
            (new ProcessLectureVideoJob($video))->handle($processor);
        } catch (Throwable $e) {
            $this->error('Processing failed: ' . $e->getMessage());

            return self::FAILURE;
        }

        $this->info('Lecture processed.');

        return self::SUCCESS;
    }
}
