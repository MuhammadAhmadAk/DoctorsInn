<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseReview extends Model
{
    use ClearsSiteCache;

    protected $fillable = [
        'course_id',
        'user_id',
        'name',
        'email',
        'rating',
        'comment',
        'status',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}
