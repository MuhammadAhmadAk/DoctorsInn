<?php

namespace App\Services;

use App\Models\LectureVideo;
use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class LectureStreamService
{
    public function playbackExpiry(): CarbonInterface
    {
        return now()->addMinutes((int) config('video.playback_url_ttl_minutes', 180));
    }

    public function playbackUrl(LectureVideo $video, ?CarbonInterface $expires = null): string
    {
        $expires = $expires ?: $this->playbackExpiry();

        if ($video->hls_path) {
            return URL::temporarySignedRoute(
                'lectures.hls',
                $expires,
                ['video' => $video->id, 'file' => $video->master_playlist ?: 'master.m3u8']
            );
        }

        return URL::temporarySignedRoute('lectures.original', $expires, ['video' => $video->id]);
    }

    public function playbackMime(LectureVideo $video): string
    {
        if ($video->hls_path) {
            return 'application/x-mpegURL';
        }

        return $video->mime_type ?: 'video/mp4';
    }

    public function canView(LectureVideo $video, bool $isAdmin, bool $isAuthenticatedStudent, ?int $userId): bool
    {
        if ($isAdmin) {
            return true;
        }

        if (! $isAuthenticatedStudent || ! $userId) {
            return false;
        }

        return $this->userCanAccessCourse($userId, $video->course_id);
    }

    /**
     * Enrollment hook. The academy currently uses open access for signed-in
     * students, but this automatically enforces an `enrollments` table when
     * one is added later.
     */
    protected function userCanAccessCourse(int $userId, ?int $courseId): bool
    {
        $user = User::find($userId);

        $hasEnrollments = false;
        try {
            $hasEnrollments = Schema::hasTable('enrollments');
        } catch (\Throwable $e) {
            $hasEnrollments = false;
        }

        // The demo student session may not have a persisted row yet.
        if (! $user) {
            return ! $hasEnrollments;
        }

        if ($user->role === 'admin') {
            return true;
        }

        if (! $courseId) {
            return true;
        }

        if (! $hasEnrollments) {
            return true;
        }

        try {
            return DB::table('enrollments')
                ->where('user_id', $userId)
                ->where('course_id', $courseId)
                ->exists();
        } catch (\Throwable $e) {
            return true;
        }
    }

    /**
     * Resolve a requested HLS file safely inside the lecture's private folder.
     */
    public function resolveFile(LectureVideo $video, string $file): ?string
    {
        if ($video->status !== 'ready' || ! $video->hls_path) {
            return null;
        }

        $file = str_replace('\\', '/', trim($file));
        $file = ltrim($file, '/');

        if ($file === '' || str_contains($file, "\0") || preg_match('#(^|/)\.\.(/|$)#', $file)) {
            return null;
        }

        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (! in_array($extension, ['m3u8', 'ts', 'm4s', 'mp4', 'key'], true)) {
            return null;
        }

        $base = $video->hlsAbsoluteDirectory();
        if (! $base) {
            return null;
        }

        $baseReal = realpath($base);
        $candidate = $baseReal . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $file);
        $real = realpath($candidate);

        if (! $baseReal || ! $real || ! is_file($real)) {
            return null;
        }

        $prefix = rtrim($baseReal, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        if (! Str::startsWith($real, $prefix)) {
            return null;
        }

        return $real;
    }

    public function isPlaylist(string $file): bool
    {
        return strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'm3u8';
    }

    /**
     * Rewrite every relative URI in a playlist to a fresh signed URL so
     * variant playlists and segments are individually authorized.
     */
    public function rewritePlaylist(LectureVideo $video, string $file, string $content, CarbonInterface $expires): string
    {
        $baseDir = trim(str_replace('\\', '/', dirname($file)), '.');
        $baseDir = trim($baseDir, '/');
        $lines = preg_split("/\r\n|\n|\r/", $content) ?: [];

        $rewritten = [];

        foreach ($lines as $line) {
            $trimmed = trim($line);

            if ($trimmed === '') {
                $rewritten[] = $line;
                continue;
            }

            if ($trimmed[0] === '#') {
                // Rewrite URI attributes such as EXT-X-MAP for future fMP4 output.
                if (preg_match('/URI="([^"]+)"/', $trimmed, $m)) {
                    $child = $this->resolveChildUri($baseDir, $m[1]);
                    if ($child !== null) {
                        $signed = $this->signedChildUrl($video, $child, $expires);
                        $trimmed = str_replace($m[1], $signed, $trimmed);
                    }
                }
                $rewritten[] = $trimmed;
                continue;
            }

            if (preg_match('#^(https?:)?//#i', $trimmed)) {
                $rewritten[] = $trimmed;
                continue;
            }

            $child = $this->resolveChildUri($baseDir, $trimmed);
            if ($child === null) {
                $rewritten[] = $trimmed;
                continue;
            }

            $rewritten[] = $this->signedChildUrl($video, $child, $expires);
        }

        return implode("\n", $rewritten) . "\n";
    }

    protected function signedChildUrl(LectureVideo $video, string $child, CarbonInterface $expires): string
    {
        return URL::temporarySignedRoute('lectures.hls', $expires, [
            'video' => $video->id,
            'file' => $child,
        ]);
    }

    protected function resolveChildUri(string $baseDir, string $uri): ?string
    {
        $uri = trim($uri);
        if ($uri === '' || str_contains($uri, "\0")) {
            return null;
        }

        $path = $baseDir !== '' ? $baseDir . '/' . $uri : $uri;
        $parts = [];

        foreach (explode('/', str_replace('\\', '/', $path)) as $part) {
            if ($part === '' || $part === '.') {
                continue;
            }
            if ($part === '..') {
                array_pop($parts);
                continue;
            }
            $parts[] = $part;
        }

        return implode('/', $parts);
    }
}
