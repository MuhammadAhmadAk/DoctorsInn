<?php

namespace App\Services;

use App\Models\LectureVideo;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

class VideoProcessingService
{
    /**
     * Resolve the configured ffmpeg/ffprobe binaries.
     *
     * @return array{ffmpeg: ?string, ffprobe: ?string}
     */
    public function binaryStatus(): array
    {
        return [
            'ffmpeg' => $this->resolveBinary(config('video.ffmpeg'), 'ffmpeg'),
            'ffprobe' => $this->resolveBinary(config('video.ffprobe'), 'ffprobe'),
        ];
    }

    /**
     * Transcode an uploaded lecture into an adaptive HLS ladder.
     *
     * @param  callable(int):void|null  $onProgress  Receives 0-100.
     */
    public function process(LectureVideo $video, ?callable $onProgress = null): void
    {
        $binaries = $this->binaryStatus();
        if (! $binaries['ffmpeg'] || ! $binaries['ffprobe']) {
            throw new RuntimeException(
                'FFmpeg / FFprobe is not installed or not reachable on this server. '
                . 'Install FFmpeg and set FFMPEG_BINARY / FFPROBE_BINARY in .env, then retry processing.'
            );
        }

        $input = $video->originalAbsolutePath();
        if (! $input) {
            throw new RuntimeException('Original video file is missing from private storage.');
        }

        $this->report($onProgress, 2);

        $meta = $this->probe($binaries['ffprobe'], $input);
        $video->forceFill([
            'duration_seconds' => $meta['duration'] > 0 ? (int) round($meta['duration']) : null,
            'width' => $meta['width'] ?: null,
            'height' => $meta['height'] ?: null,
            'progress' => 4,
        ])->save();
        $this->report($onProgress, 4);

        if ($meta['height'] < 2 || $meta['width'] < 2) {
            throw new RuntimeException('Could not detect a valid video stream in the uploaded file.');
        }

        $renditions = $this->buildRenditionLadder($meta['height']);
        $disk = Storage::disk(LectureVideo::diskName());
        $hlsRelative = 'hls/' . $video->id;

        if ($disk->exists($hlsRelative)) {
            $disk->deleteDirectory($hlsRelative);
        }
        $disk->makeDirectory($hlsRelative);
        $hlsDir = $disk->path($hlsRelative);

        $totalRenditions = count($renditions);
        $completed = 0;
        $ladder = [];
        $lastReportedAt = 0.0;

        foreach ($renditions as $index => $rendition) {
            $outDir = $hlsDir . DIRECTORY_SEPARATOR . $rendition['height'] . 'p';
            if (! is_dir($outDir) && ! @mkdir($outDir, 0775, true) && ! is_dir($outDir)) {
                throw new RuntimeException('Unable to create HLS output directory.');
            }

            $this->runFfmpeg(
                $binaries['ffmpeg'],
                $input,
                $outDir,
                $rendition,
                $meta['duration'],
                function (float $ratio) use ($index, $totalRenditions, $onProgress, &$lastReportedAt) {
                    $now = microtime(true);
                    if ($now - $lastReportedAt < 1.5) {
                        return;
                    }
                    $lastReportedAt = $now;
                    $percent = (int) floor(8 + ((($index + min(1, $ratio)) / max(1, $totalRenditions)) * 84));
                    $this->report($onProgress, min(95, $percent));
                }
            );

            $completed++;
            $outWidth = max(2, (int) (round(($meta['width'] * $rendition['height'] / $meta['height']) / 2) * 2));
            $bandwidth = (int) round(($rendition['video_bitrate'] + $rendition['audio_bitrate']) * 1.08);

            $ladder[$rendition['height'] . 'p'] = [
                'height' => $rendition['height'],
                'width' => $outWidth,
                'bandwidth' => $bandwidth,
                'codecs' => $rendition['codecs'],
            ];

            $this->report($onProgress, min(95, (int) floor(8 + (($completed / max(1, $totalRenditions)) * 84))));
        }

        $master = $this->writeMasterPlaylist($ladder);
        $disk->put($hlsRelative . '/master.m3u8', $master);

        $video->forceFill([
            'status' => 'ready',
            'progress' => 100,
            'error_message' => null,
            'qualities' => $ladder,
            'hls_path' => $hlsRelative,
            'master_playlist' => 'master.m3u8',
            'processed_at' => now(),
        ])->save();

        $this->report($onProgress, 100);
    }

    /**
     * @return array{duration: float, width: int, height: int}
     */
    public function probe(string $ffprobe, string $input): array
    {
        $process = new Process([
            $ffprobe,
            '-v', 'error',
            '-print_format', 'json',
            '-show_format',
            '-show_streams',
            $input,
        ]);
        $process->setTimeout(120);
        $process->run();

        if (! $process->isSuccessful()) {
            throw new RuntimeException('FFprobe could not read the video: ' . trim($process->getErrorOutput()));
        }

        $data = json_decode($process->getOutput(), true);
        if (! is_array($data)) {
            throw new RuntimeException('FFprobe returned invalid metadata.');
        }

        $videoStream = null;
        foreach (($data['streams'] ?? []) as $stream) {
            if (($stream['codec_type'] ?? '') === 'video') {
                $videoStream = $stream;
                break;
            }
        }

        if (! $videoStream) {
            throw new RuntimeException('The uploaded file does not contain a video stream.');
        }

        $duration = (float) ($data['format']['duration'] ?? $videoStream['duration'] ?? 0);
        if ($duration <= 0 && ! empty($videoStream['nb_frames']) && ! empty($videoStream['avg_frame_rate'])) {
            [$num, $den] = array_pad(explode('/', (string) $videoStream['avg_frame_rate']), 2, 1);
            if ((float) $den > 0) {
                $duration = (float) $videoStream['nb_frames'] * ((float) $den / (float) $num);
            }
        }

        return [
            'duration' => max(0, $duration),
            'width' => (int) ($videoStream['width'] ?? 0),
            'height' => (int) ($videoStream['height'] ?? 0),
        ];
    }

    /**
     * Only renditions at or below the source height (never upscale).
     *
     * @return array<int, array<string, mixed>>
     */
    protected function buildRenditionLadder(int $sourceHeight): array
    {
        $configured = collect(config('video.renditions', []))
            ->filter(fn ($r) => (int) $r['height'] <= $sourceHeight)
            ->sortBy('height')
            ->values()
            ->all();

        if (! empty($configured)) {
            return $configured;
        }

        // Source is smaller than 360p: encode a single rendition at source height.
        $height = max(2, $sourceHeight - ($sourceHeight % 2));
        $videoBitrate = (int) max(250000, min(800000, $height * 2500));

        return [[
            'height' => $height,
            'video_bitrate' => $videoBitrate,
            'maxrate' => (int) round($videoBitrate * 1.12),
            'bufsize' => $videoBitrate * 2,
            'audio_bitrate' => 96000,
            'level' => '3.0',
            'codecs' => 'avc1.4d401e,mp4a.40.2',
        ]];
    }

    protected function runFfmpeg(
        string $ffmpeg,
        string $input,
        string $outDir,
        array $rendition,
        float $duration,
        callable $onRatio
    ): void {
        $segmentSeconds = max(2, (int) config('video.hls_segment_seconds', 6));
        $gop = $segmentSeconds * 25;

        $command = [
            $ffmpeg,
            '-y',
            '-hide_banner',
            '-loglevel', 'error',
            '-progress', 'pipe:1',
            '-nostats',
            '-i', $input,
            '-map', '0:v:0',
            '-map', '0:a:0?',
            '-vf', 'scale=-2:' . $rendition['height'] . ':flags=lanczos,setsar=1,format=yuv420p',
            '-c:v', 'libx264',
            '-preset', 'veryfast',
            '-profile:v', 'main',
            '-level', (string) $rendition['level'],
            '-b:v', (string) $rendition['video_bitrate'],
            '-maxrate', (string) $rendition['maxrate'],
            '-bufsize', (string) $rendition['bufsize'],
            '-g', (string) $gop,
            '-keyint_min', (string) $gop,
            '-sc_threshold', '0',
            '-force_key_frames', 'expr:gte(t,n_forced*' . $segmentSeconds . ')',
            '-c:a', 'aac',
            '-b:a', (string) $rendition['audio_bitrate'],
            '-ac', '2',
            '-ar', '48000',
            '-hls_time', (string) $segmentSeconds,
            '-hls_playlist_type', 'vod',
            '-hls_flags', 'independent_segments',
            '-hls_segment_filename', $outDir . DIRECTORY_SEPARATOR . 'segment_%04d.ts',
            $outDir . DIRECTORY_SEPARATOR . 'index.m3u8',
        ];

        $process = new Process($command);
        $process->setTimeout((int) config('video.process_timeout_seconds', 3600));

        $buffer = '';
        $process->run(function (string $type, string $chunk) use (&$buffer, $duration, $onRatio) {
            if ($type !== Process::OUT) {
                return;
            }

            $buffer .= $chunk;
            while (($pos = strpos($buffer, "\n")) !== false) {
                $line = trim(substr($buffer, 0, $pos));
                $buffer = substr($buffer, $pos + 1);

                if ($duration > 0 && preg_match('/^out_time_ms=(\d+)$/', $line, $m)) {
                    // ffmpeg reports microseconds despite the name.
                    $seconds = ((int) $m[1]) / 1_000_000;
                    $onRatio(max(0.0, min(1.0, $seconds / $duration)));
                }
            }
        });

        if (! $process->isSuccessful()) {
            $error = trim($process->getErrorOutput());
            throw new RuntimeException(
                'FFmpeg failed for ' . $rendition['height'] . 'p: ' . ($error !== '' ? $error : 'unknown encoder error')
            );
        }
    }

    protected function writeMasterPlaylist(array $ladder): string
    {
        $lines = ['#EXTM3U', '#EXT-X-VERSION:3', '#EXT-X-INDEPENDENT-SEGMENTS'];

        foreach ($ladder as $quality) {
            $lines[] = sprintf(
                '#EXT-X-STREAM-INF:BANDWIDTH=%d,RESOLUTION=%dx%d,CODECS="%s"',
                $quality['bandwidth'],
                $quality['width'],
                $quality['height'],
                $quality['codecs']
            );
            $lines[] = $quality['height'] . 'p/index.m3u8';
        }

        return implode("\n", $lines) . "\n";
    }

    protected function report(?callable $callback, int $percent): void
    {
        if ($callback) {
            $callback(max(0, min(100, $percent)));
        }
    }

    protected function resolveBinary(?string $configured, string $fallback): ?string
    {
        if (! empty($configured)) {
            if (is_file($configured)) {
                return $configured;
            }

            $found = (new ExecutableFinder())->find($configured);
            if ($found) {
                return $found;
            }
        }

        return (new ExecutableFinder())->find($fallback);
    }
}
