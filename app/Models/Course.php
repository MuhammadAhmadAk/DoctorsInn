<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use ClearsSiteCache;

    public function lectureVideos(): HasMany
    {
        return $this->hasMany(LectureVideo::class);
    }

    protected $fillable = [
        'slug', 'category', 'category_name', 'title', 'price', 'original_price',
        'rating', 'rating_count', 'lessons', 'students', 'duration', 'level',
        'language', 'instructor', 'image', 'detail_image', 'instructor_image',
        'success_badge', 'overview', 'what_will_you_learn', 'curriculum',
        'instructor_info', 'success_stories', 'reviews', 'is_featured', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'what_will_you_learn' => 'array',
        'curriculum' => 'array',
        'instructor_info' => 'array',
        'success_stories' => 'array',
        'reviews' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function toFrontendArray(): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'category' => $this->category,
            'category_name' => $this->category_name,
            'title' => $this->title,
            'price' => $this->price,
            'original_price' => $this->original_price,
            'rating' => $this->rating,
            'rating_count' => $this->rating_count,
            'lessons' => $this->lessons,
            'students' => $this->students,
            'duration' => $this->duration,
            'level' => $this->level,
            'language' => $this->language,
            'instructor' => $this->instructor,
            'image' => $this->image ?: 'frontend/img/course/course1-1.jpg',
            'detail_image' => $this->detail_image ?: ($this->image ?: 'frontend/img/course/course1-1.jpg'),
            'instructor_image' => $this->instructor_image ?: 'frontend/img/course/course-thumb1-1.png',
            'success_badge' => $this->success_badge,
            'overview' => $this->overview,
            'what_will_you_learn' => $this->what_will_you_learn ?? [],
            'curriculum' => $this->curriculum ?? [],
            'modules' => (is_array($this->curriculum) && !empty($this->curriculum) && isset($this->curriculum[0]['chapters']))
                ? $this->curriculum
                : ($this->modules ?? []),
            'instructor_info' => $this->instructor_info ?? ['name' => $this->instructor ?? 'DoctorsInn'],
            'success_stories' => $this->success_stories ?? [],
            'reviews' => $this->reviews ?? [],
        ];
    }
}
