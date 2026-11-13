<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LectureProgress extends Model
{
    protected $table = 'lecture_progress';

    protected $fillable = [
        'user_id',
        'lecture_video_id',
        'course_id',
        'topic_id',
        'position_seconds',
        'duration_seconds',
        'percent',
        'completed',
        'completed_at',
        'last_watched_at',
    ];

    protected $casts = [
        'position_seconds' => 'integer',
        'duration_seconds' => 'integer',
        'percent' => 'integer',
        'completed' => 'boolean',
        'completed_at' => 'datetime',
        'last_watched_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lecture(): BelongsTo
    {
        return $this->belongsTo(LectureVideo::class, 'lecture_video_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
