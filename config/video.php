<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Lecture Video Storage
    |--------------------------------------------------------------------------
    | Private disk where original uploads and generated HLS output live.
    | Files are never exposed directly by the web server; all playback is
    | served through the signed streaming controller.
    */

    'disk' => env('LECTURE_DISK', 'lectures'),

    /*
    |--------------------------------------------------------------------------
    | FFmpeg Binaries
    |--------------------------------------------------------------------------
    | Absolute path or executable name. When a name is supplied the service
    | will also try to locate the binary automatically on the system PATH.
    */

    'ffmpeg' => env('FFMPEG_BINARY', 'ffmpeg'),
    'ffprobe' => env('FFPROBE_BINARY', 'ffprobe'),

    /*
    |--------------------------------------------------------------------------
    | HLS Encoding
    |--------------------------------------------------------------------------
    */

    'hls_segment_seconds' => (int) env('HLS_SEGMENT_SECONDS', 6),

    /*
    |--------------------------------------------------------------------------
    | Encoder Threads
    |--------------------------------------------------------------------------
    | Shared hosts often limit per-process threads; x264 auto-detecting every
    | CPU core fails to initialise the encoder alongside the audio stream.
    */

    'ffmpeg_threads' => (int) env('FFMPEG_THREADS', 4),

    'completion_threshold' => (int) env('LECTURE_COMPLETION_THRESHOLD', 90),

    'playback_url_ttl_minutes' => (int) env('LECTURE_PLAYBACK_TTL_MINUTES', 180),

    'process_timeout_seconds' => (int) env('LECTURE_PROCESS_TIMEOUT', 14400),

    /*
    |--------------------------------------------------------------------------
    | Adaptive Renditions
    |--------------------------------------------------------------------------
    | Only renditions whose height is <= the source height are generated,
    | so low resolution uploads are never upscaled.
    */

    'renditions' => [
        [
            'height' => 360,
            'video_bitrate' => 800000,
            'maxrate' => 900000,
            'bufsize' => 1800000,
            'audio_bitrate' => 96000,
            'level' => '3.0',
            'codecs' => 'avc1.4d401e,mp4a.40.2',
        ],
        [
            'height' => 480,
            'video_bitrate' => 1200000,
            'maxrate' => 1350000,
            'bufsize' => 2700000,
            'audio_bitrate' => 128000,
            'level' => '3.1',
            'codecs' => 'avc1.4d401f,mp4a.40.2',
        ],
        [
            'height' => 720,
            'video_bitrate' => 2500000,
            'maxrate' => 2800000,
            'bufsize' => 5600000,
            'audio_bitrate' => 128000,
            'level' => '3.1',
            'codecs' => 'avc1.4d401f,mp4a.40.2',
        ],
        [
            'height' => 1080,
            'video_bitrate' => 5000000,
            'maxrate' => 5600000,
            'bufsize' => 11200000,
            'audio_bitrate' => 192000,
            'level' => '4.0',
            'codecs' => 'avc1.4d4028,mp4a.40.2',
        ],
    ],

];
