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

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function reviewsList(): HasMany
    {
        return $this->hasMany(CourseReview::class);
    }

    /**
     * Course prices are stored as display strings ("Free", "Rs 12,000").
     * Return the numeric amount in paisa (PKR * 100) for the gateway.
     */
    public function priceInPaisa(): int
    {
        $raw = trim((string) $this->price);

        if ($raw === '' || stripos($raw, 'free') !== false) {
            return 0;
        }

        // Match the number itself so a "Rs." prefix dot is not read as a decimal point.
        if (! preg_match('/\d[\d,]*(?:\.\d+)?/', $raw, $match)) {
            return 0;
        }

        return (int) round((float) str_replace(',', '', $match[0]) * 100);
    }

    public function isFree(): bool
    {
        return $this->priceInPaisa() <= 0;
    }

    public function priceLabel(): string
    {
        $raw = trim((string) $this->price);

        return $raw === '' ? 'Free' : $raw;
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
            'price_paisa' => $this->priceInPaisa(),
            'is_free' => $this->isFree(),
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
            'reviews' => ($this->relationLoaded('reviewsList') && $this->reviewsList->isNotEmpty())
                ? $this->reviewsList->where('status', 'approved')->map(fn ($r) => [
                    'id' => $r->id,
                    'name' => $r->name,
                    'rating' => (int) $r->rating,
                    'comment' => $r->comment,
                    'date' => $r->created_at ? $r->created_at->format('M d, Y') : 'Recently',
                ])->values()->all()
                : ($this->reviews ?? []),
        ];
    }
}
