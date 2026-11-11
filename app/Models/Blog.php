<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use ClearsSiteCache;

    protected $fillable = [
        'slug', 'title', 'category', 'short_description', 'content', 'image',
        'author', 'tags', 'read_time', 'date_day', 'date_month', 'date_year',
        'is_published', 'sort_order',
    ];

    protected $casts = [
        'content' => 'array',
        'author' => 'array',
        'tags' => 'array',
        'is_published' => 'boolean',
    ];

    public function toFrontendArray(): array
    {
        $rawContent = $this->content;
        if (is_string($rawContent) && $rawContent !== '') {
            $rawContent = preg_split("/\r\n|\n|\r/", trim($rawContent)) ?: [$rawContent];
        }

        $author = is_array($this->author) ? $this->author : [];
        $author = array_merge([
            'name' => 'DoctorsInn Academic Team',
            'designation' => 'Senior Medical Mentors',
            'image' => 'frontend/img/blog/blog-author.jpg',
            'bio' => 'DoctorsInn provides high-yield MDCAT, NUMS & AMC entry test preparation, comprehensive mock series, and personalized mentorship across Pakistan.',
        ], $author);

        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'category' => $this->category,
            'short_description' => $this->short_description,
            'content' => is_array($rawContent) ? array_values(array_filter($rawContent)) : [],
            'image' => $this->image ?: 'frontend/img/blog/blog_1_1.jpg',
            'detail_image' => $this->image ?: 'frontend/img/blog/blog_1_1.jpg',
            'author' => $author,
            'tags' => $this->tags ?? [],
            'read_time' => $this->read_time,
            'date_day' => $this->date_day ?: date('d'),
            'date_month' => $this->date_month ?: date('M'),
            'date_year' => $this->date_year ?: date('Y'),
        ];
    }
}
