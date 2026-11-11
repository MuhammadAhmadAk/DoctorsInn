<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use Illuminate\Database\Eloquent\Model;

class MockTest extends Model
{
    use ClearsSiteCache;

    protected $fillable = [
        'slug', 'title', 'category', 'category_name', 'badge',
        'duration_minutes', 'total_questions', 'marks_per_question',
        'passing_percentage', 'difficulty', 'attempts', 'image',
        'description', 'questions', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'questions' => 'array',
        'is_active' => 'boolean',
    ];

    public function toFrontendArray(): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'category' => $this->category,
            'category_name' => $this->category_name,
            'badge' => $this->badge,
            'duration_minutes' => $this->duration_minutes,
            'total_questions' => $this->total_questions,
            'marks_per_question' => $this->marks_per_question,
            'passing_percentage' => $this->passing_percentage,
            'difficulty' => $this->difficulty,
            'attempts' => $this->attempts,
            'image' => $this->image ?: 'frontend/img/course/course1-1.jpg',
            'description' => $this->description,
            'questions' => $this->questions ?? [],
        ];
    }
}
