<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessLectureVideoJob;
use App\Models\LectureVideo;
use App\Services\VideoProcessingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use Throwable;

class AdminLectureController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $maxKb = $this->maxUploadKb();

        $data = $request->validate([
            'video' => ['required', 'file', 'max:' . $maxKb, 'mimes:mp4,mov,m4v,webm,mkv,avi,qt'],
            'title' => ['nullable', 'string', 'max:190'],
            'course_id' => ['nullable', 'integer', 'exists:courses,id'],
            'topic_id' => ['nullable', 'string', 'max:191'],
        ], [
            'video.max' => 'This video is larger than the server upload limit (' . $this->humanSize($maxKb * 1024) . '). Increase upload_max_filesize / post_max_size in php.ini.',
        ]);

        $file = $request->file('video');
        $extension = strtolower($file->getClientOriginalExtension() ?: 'mp4');
        if (! in_array($extension, ['mp4', 'mov', 'm4v', 'webm', 'mkv', 'avi', 'qt'], true)) {
            return response()->json(['message' => 'Unsupported video format.'], 422);
        }

        $title = trim((string) ($data['title'] ?? ''));
        if ($title === '') {
            $title = Str::limit(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), 190, '');
        }

        $storedName = 'originals/' . Str::uuid() . '.' . $extension;
        $file->storeAs('originals', basename($storedName), ['disk' => LectureVideo::diskName()]);

        $video = LectureVideo::create([
            'course_id' => $data['course_id'] ?? null,
            'topic_id' => $data['topic_id'] ?? null,
            'title' => $title,
            'original_filename' => Str::limit($file->getClientOriginalName(), 255, ''),
            'original_path' => $storedName,
            'mime_type' => $file->getClientMimeType(),
            'size_bytes' => $file->getSize() ?: 0,
            'status' => 'queued',
            'progress' => 0,
        ]);

        $binaries = app(VideoProcessingService::class)->binaryStatus();
        $ffmpegReady = (bool) ($binaries['ffmpeg'] && $binaries['ffprobe']);

        if (! $ffmpegReady) {
            // No transcoder available: publish the original file via a signed
            // progressive route so topic lectures still play immediately.
            $video->forceFill([
                'status' => 'ready',
                'progress' => 100,
                'error_message' => null,
                'qualities' => null,
                'hls_path' => null,
                'processed_at' => now(),
            ])->save();
        } else {
            $this->dispatchProcessing($video);
        }

        return response()->json([
            'message' => $ffmpegReady
                ? 'Video uploaded. Processing has started in the background.'
                : 'Video uploaded and is ready to play. Install FFmpeg to enable adaptive HLS.',
            'lecture' => $this->serialize($video->fresh()),
            'ffmpeg_available' => $ffmpegReady,
        ], 201);
    }

    public function status(LectureVideo $video): JsonResponse
    {
        return response()
            ->json($this->serialize($video->fresh()))
            ->header('Cache-Control', 'no-store, max-age=0');
    }

    public function retry(LectureVideo $video): JsonResponse
    {
        $binaries = app(VideoProcessingService::class)->binaryStatus();
        if (! $binaries['ffmpeg'] || ! $binaries['ffprobe']) {
            return response()->json([
                'message' => 'FFmpeg / FFprobe is not installed on this server. Install it and set FFMPEG_BINARY / FFPROBE_BINARY, then retry.',
            ], 422);
        }

        if (! $video->originalAbsolutePath()) {
            return response()->json(['message' => 'The original upload is missing. Upload the video again.'], 422);
        }

        Storage::disk(LectureVideo::diskName())->deleteDirectory($video->hls_path ?: 'hls/' . $video->id);

        $video->forceFill([
            'status' => 'queued',
            'progress' => 0,
            'error_message' => null,
            'hls_path' => null,
            'qualities' => null,
            'processed_at' => null,
        ])->save();

        $this->dispatchProcessing($video);

        return response()->json(['message' => 'Processing restarted.', 'lecture' => $this->serialize($video->fresh())]);
    }

    public function destroy(LectureVideo $video): JsonResponse
    {
        try {
            $disk = Storage::disk(LectureVideo::diskName());

            // 1. Delete HLS rendition directory
            $hlsDir = $video->hls_path ?: ('hls/' . $video->id);
            if ($disk->exists($hlsDir)) {
                $disk->deleteDirectory($hlsDir);
            }

            // 2. Delete original source video file
            if ($video->original_path && $disk->exists($video->original_path)) {
                $disk->delete($video->original_path);
            }

            // 3. Delete processing log if present
            $logFile = storage_path('logs/lecture-' . $video->id . '.log');
            if (is_file($logFile)) {
                @unlink($logFile);
            }

            // 4. Delete progress tracking records
            $video->progressRecords()->delete();

            // 5. Delete database record
            $video->delete();

            return response()->json([
                'success' => true,
                'message' => 'Lecture video and all associated media files permanently deleted.',
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete lecture: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Transcoding must not depend on a long-running queue worker: shared hosts
     * kill those daemons and uploads silently stall. Spawn a detached CLI
     * process for this lecture instead, falling back to the queue only when the
     * process cannot be started.
     */
    protected function dispatchProcessing(LectureVideo $video): void
    {
        if ($this->spawnProcessor($video)) {
            return;
        }

        if (config('queue.default') === 'sync') {
            ProcessLectureVideoJob::dispatch($video)->afterResponse();

            return;
        }

        ProcessLectureVideoJob::dispatch($video);
    }

    protected function spawnProcessor(LectureVideo $video): bool
    {
        // Keep this a single simple command: a compound (`cd && nohup ... &`)
        // leaves the wrapping shell holding proc_open's pipes open, which would
        // block the upload response until transcoding finishes.
        $command = sprintf(
            'nohup %s %s lectures:process %d >> %s 2>&1 < /dev/null &',
            escapeshellarg($this->phpBinary()),
            escapeshellarg(base_path('artisan')),
            (int) $video->id,
            escapeshellarg(storage_path('logs/lecture-' . $video->id . '.log'))
        );

        try {
            $process = Process::fromShellCommandline($command, base_path(), null, null, 15);
            $process->disableOutput();
            $process->run();

            return $process->isSuccessful();
        } catch (Throwable $e) {
            Log::warning('Could not spawn standalone lecture processor', [
                'lecture_video_id' => $video->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    protected function phpBinary(): string
    {
        if (PHP_SAPI === 'cli' && is_file(PHP_BINARY)) {
            return PHP_BINARY;
        }

        foreach ([PHP_BINDIR . '/php', PHP_BINDIR . '/php.exe'] as $candidate) {
            if (is_file($candidate)) {
                return $candidate;
            }
        }

        return 'php';
    }

    protected function serialize(?LectureVideo $video): array
    {
        if (! $video) {
            return [];
        }

        $type = null;
        if ($video->status === 'ready') {
            $type = $video->hls_path ? 'application/x-mpegURL' : ($video->mime_type ?: 'video/mp4');
        }

        return [
            'id' => $video->id,
            'title' => $video->title,
            'status' => $video->status,
            'progress' => (int) $video->progress,
            'ready' => $video->status === 'ready',
            'hls' => (bool) $video->hls_path,
            'type' => $type,
            'error' => $video->error_message,
            'duration' => $video->duration_seconds,
            'qualities' => array_keys($video->qualities ?: []),
            'course_id' => $video->course_id,
            'topic_id' => $video->topic_id,
            'size_bytes' => $video->size_bytes,
            'updated_at' => optional($video->updated_at)->toIso8601String(),
        ];
    }

    protected function maxUploadKb(): int
    {
        $bytes = $this->parseIniSize(ini_get('upload_max_filesize') ?: '2M');
        $postBytes = $this->parseIniSize(ini_get('post_max_size') ?: '8M');
        $bytes = min($bytes, $postBytes > 0 ? $postBytes : $bytes);

        return max(1024, (int) floor($bytes / 1024));
    }

    protected function parseIniSize(string $value): int
    {
        $value = trim($value);
        if ($value === '' || $value === '-1') {
            return 0;
        }

        $unit = strtolower(substr($value, -1));
        $number = (float) $value;

        return (int) match ($unit) {
            'g' => $number * 1073741824,
            'm' => $number * 1048576,
            'k' => $number * 1024,
            default => (float) $value,
        };
    }

    protected function humanSize(int $bytes): string
    {
        if ($bytes >= 1073741824) {
            return round($bytes / 1073741824, 1) . ' GB';
        }

        return round($bytes / 1048576, 1) . ' MB';
    }
}
