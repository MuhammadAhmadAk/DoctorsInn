<?php

namespace App\Http\Controllers;

use App\Models\LectureProgress;
use App\Models\LectureVideo;
use App\Models\User;
use App\Services\LectureStreamService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LectureStreamController extends Controller
{
    public function __construct(protected LectureStreamService $streams)
    {
    }

    /**
     * Signed endpoint serving both HLS playlists and media segments.
     */
    public function stream(Request $request, LectureVideo $video, string $file)
    {
        $this->authorizeView($request, $video);

        if ($video->status !== 'ready') {
            abort(404);
        }

        $path = $this->streams->resolveFile($video, $file);
        if (! $path) {
            abort(404);
        }

        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if ($this->streams->isPlaylist($file)) {
            $expires = $this->streams->playbackExpiry();
            $content = @file_get_contents($path);
            if ($content === false) {
                abort(404);
            }

            $rewritten = $this->streams->rewritePlaylist($video, $file, $content, $expires);

            return response($rewritten, 200, [
                'Content-Type' => 'application/vnd.apple.mpegurl',
                'Cache-Control' => 'private, max-age=30',
                'X-Content-Type-Options' => 'nosniff',
            ]);
        }

        $mime = [
            'ts' => 'video/mp2t',
            'm4s' => 'video/iso.segment',
            'mp4' => 'video/mp4',
            'key' => 'application/octet-stream',
        ][$extension] ?? 'application/octet-stream';

        return response()->file($path, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline',
            'Cache-Control' => 'private, max-age=3600, immutable',
            'X-Content-Type-Options' => 'nosniff',
            'Accept-Ranges' => 'bytes',
        ]);
    }

    /**
     * Direct-progress fallback for lectures uploaded while FFmpeg is unavailable.
     */
    public function streamOriginal(Request $request, LectureVideo $video)
    {
        $this->authorizeView($request, $video);

        if ($video->status !== 'ready' || $video->hls_path) {
            abort(404);
        }

        $path = $video->originalAbsolutePath();
        if (! $path) {
            abort(404);
        }

        return response()->file($path, [
            'Content-Type' => $video->mime_type ?: 'video/mp4',
            'Content-Disposition' => 'inline',
            'Cache-Control' => 'private, max-age=3600',
            'X-Content-Type-Options' => 'nosniff',
            'Accept-Ranges' => 'bytes',
        ]);
    }

    public function playbackUrl(Request $request, LectureVideo $video): JsonResponse
    {
        $this->authorizeView($request, $video);

        if ($video->status !== 'ready' || (! $video->hls_path && ! $video->original_path)) {
            return response()->json([
                'ready' => false,
                'status' => $video->status,
                'message' => 'This lecture is still being processed.',
            ], 409);
        }

        return response()->json([
            'ready' => true,
            'url' => $this->streams->playbackUrl($video),
            'type' => $this->streams->playbackMime($video),
            'expires_in' => (int) config('video.playback_url_ttl_minutes', 180) * 60,
        ]);
    }

    public function saveProgress(Request $request, LectureVideo $video): JsonResponse
    {
        $userId = Auth::id() ?: (int) session('user.id');
        if (! $userId) {
            return response()->json(['saved' => false, 'message' => 'Authentication required.'], 401);
        }

        if (! $this->streams->canView($video, false, true, $userId)) {
            return response()->json(['saved' => false, 'message' => 'You do not have access to this lecture.'], 403);
        }

        $data = $request->validate([
            'position' => 'nullable|numeric|min:0',
            'duration' => 'nullable|numeric|min:0',
        ]);

        $position = (int) floor((float) ($data['position'] ?? 0));
        $duration = (int) floor((float) ($data['duration'] ?? 0));
        if ($duration <= 0) {
            $duration = (int) ($video->duration_seconds ?? 0);
        }

        $percent = $duration > 0 ? (int) min(100, round(($position / $duration) * 100)) : 0;
        $threshold = (int) config('video.completion_threshold', 90);
        $isComplete = $duration > 0 && ($percent >= $threshold || $position >= $duration - 2);

        $userExists = User::whereKey($userId)->exists();
        if (! $userExists) {
            return response()->json(['saved' => false, 'completed' => false, 'percent' => $percent]);
        }

        $progress = LectureProgress::firstOrNew([
            'user_id' => $userId,
            'lecture_video_id' => $video->id,
        ]);

        $progress->fill([
            'course_id' => $video->course_id,
            'topic_id' => $video->topic_id,
            'position_seconds' => $position,
            'duration_seconds' => $duration,
            'percent' => $percent,
            'last_watched_at' => now(),
        ]);

        if ($isComplete && ! $progress->completed) {
            $progress->completed = true;
            $progress->completed_at = now();
            $progress->percent = max($percent, $threshold);
        }

        if ($progress->completed) {
            $progress->percent = max($percent, (int) $progress->percent);
        }

        $progress->save();

        return response()->json([
            'saved' => true,
            'completed' => (bool) $progress->completed,
            'percent' => (int) $progress->percent,
            'position' => $position,
        ]);
    }

    /**
     * Admin helper used by the studio preview (session-protected route group).
     */
    public function adminPlaybackUrl(LectureVideo $video): JsonResponse
    {
        if ($video->status !== 'ready' || (! $video->hls_path && ! $video->original_path)) {
            return response()->json([
                'ready' => false,
                'status' => $video->status,
                'progress' => $video->progress,
                'message' => $video->error_message ?: 'Lecture is still being processed.',
            ], 409);
        }

        return response()->json([
            'ready' => true,
            'url' => $this->streams->playbackUrl($video),
            'type' => $this->streams->playbackMime($video),
            'expires_in' => (int) config('video.playback_url_ttl_minutes', 180) * 60,
        ]);
    }

    protected function authorizeView(Request $request, LectureVideo $video): void
    {
        if ($request->session()->has('admin_user')) {
            return;
        }

        $user = Auth::user();
        $sessionStudent = session('user');
        $userId = $user?->id ?: (is_array($sessionStudent) ? ($sessionStudent['id'] ?? null) : null);

        if (! $user && ! $sessionStudent) {
            abort(403, 'You are not allowed to watch this lecture.');
        }

        if (! $userId) {
            $allowed = $this->streams->canView($video, false, true, null);
        } else {
            // HLS players request dozens of segments per lecture; cache the
            // access decision so each segment does not repeat the user/enrollment
            // lookups on top of an already costly PHP bootstrap.
            $allowed = Cache::remember(
                'lecture-access:' . (int) $userId . ':' . ($video->course_id ?? 0),
                now()->addMinutes(5),
                fn () => $this->streams->canView($video, false, true, (int) $userId)
            );
        }

        if (! $allowed) {
            abort(403, 'You are not allowed to watch this lecture.');
        }
    }
}
