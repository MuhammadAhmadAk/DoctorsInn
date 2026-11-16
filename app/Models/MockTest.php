<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MockTest extends Model
{
    use ClearsSiteCache;

    protected $fillable = [
        'slug', 'title', 'category', 'category_name', 'badge',
        'duration_minutes', 'total_questions', 'marks_per_question',
        'passing_percentage', 'difficulty', 'attempts', 'image',
        'description', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function questionBank(): HasMany
    {
        return $this->hasMany(MockTestQuestion::class)->orderBy('sort_order')->orderBy('id');
    }

    public function toFrontendArray(): array
    {
        $questions = $this->frontendQuestions();

        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'category' => $this->category,
            'category_name' => $this->category_name,
            'badge' => $this->badge,
            'duration_minutes' => $this->duration_minutes,
            'total_questions' => $questions ? count($questions) : (int) $this->total_questions,
            'marks_per_question' => $this->marks_per_question,
            'passing_percentage' => $this->passing_percentage,
            'difficulty' => $this->difficulty,
            'attempts' => $this->attempts,
            'image' => $this->image ?: 'frontend/img/course/course1-1.jpg',
            'description' => $this->description,
            'questions' => $questions,
        ];
    }

    protected function frontendQuestions(): array
    {
        return $this->questionBank
            ->where('is_active', true)
            ->values()
            ->map(fn (MockTestQuestion $q) => [
                'id' => $q->id,
                'subject' => $q->subject ?: 'General',
                'question' => $q->question,
                'options' => $q->options ?: [],
                'correct' => $q->correct_option,
                'explanation' => $q->explanation ?: 'No explanation provided.',
            ])
            ->all();
    }
}
