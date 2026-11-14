<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestAttempt extends Model
{
    protected $fillable = [
        'user_id', 'mock_test_id', 'test_slug', 'test_title', 'test_category_name',
        'marks_per_question', 'total_questions', 'correct_count', 'incorrect_count',
        'skipped_count', 'score', 'total_marks', 'percentage', 'passed', 'passing_percentage',
        'time_spent_seconds', 'breakdown', 'subject_stats',
    ];

    protected $casts = [
        'passed' => 'boolean',
        'percentage' => 'float',
        'breakdown' => 'array',
        'subject_stats' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function mockTest(): BelongsTo
    {
        return $this->belongsTo(MockTest::class);
    }
}
