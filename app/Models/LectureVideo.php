<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class LectureVideo extends Model
{
    protected $fillable = [
        'course_id',
        'topic_id',
        'title',
        'original_filename',
        'original_path',
        'mime_type',
        'size_bytes',
        'status',
        'progress',
        'error_message',
        'duration_seconds',
        'width',
        'height',
        'qualities',
        'hls_path',
        'master_playlist',
        'processing_started_at',
        'processed_at',
    ];

    protected $casts = [
        'qualities' => 'array',
        'size_bytes' => 'integer',
        'duration_seconds' => 'integer',
        'width' => 'integer',
        'height' => 'integer',
        'progress' => 'integer',
        'processing_started_at' => 'datetime',
        'processed_at' => 'datetime',
    ];

    protected $appends = ['is_ready'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function progressRecords(): HasMany
    {
        return $this->hasMany(LectureProgress::class);
    }

    public function getIsReadyAttribute(): bool
    {
        return $this->status === 'ready';
    }

    public function scopeReady($query)
    {
        return $query->where('status', 'ready');
    }

    public static function diskName(): string
    {
        return config('video.disk', 'lectures');
    }

    public function originalAbsolutePath(): ?string
    {
        if (! $this->original_path) {
            return null;
        }

        $disk = Storage::disk(self::diskName());

        return $disk->exists($this->original_path) ? $disk->path($this->original_path) : null;
    }

    public function hlsAbsoluteDirectory(): ?string
    {
        if (! $this->hls_path) {
            return null;
        }

        $disk = Storage::disk(self::diskName());

        return $disk->exists($this->hls_path) ? $disk->path($this->hls_path) : null;
    }

    public function hlsAbsolutePath(?string $file = null): ?string
    {
        $dir = $this->hlsAbsoluteDirectory();
        if (! $dir) {
            return null;
        }

        return rtrim($dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . ltrim($file ?: $this->master_playlist, '/\\');
    }
}
