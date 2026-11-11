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
        'author' => 'array',
        'tags' => 'array',
        'is_published' => 'boolean',
    ];

    public function toFrontendArray(): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'category' => $this->category,
            'short_description' => $this->short_description,
            'content' => $this->content,
            'image' => $this->image ?: 'frontend/img/blog/blog_1_1.jpg',
            'author' => $this->author ?? ['name' => 'DoctorsInn Editorial Team', 'avatar' => 'frontend/img/team/team_2_1.jpg'],
            'tags' => $this->tags ?? [],
            'read_time' => $this->read_time,
            'date_day' => $this->date_day ?: date('d'),
            'date_month' => $this->date_month ?: date('M'),
            'date_year' => $this->date_year ?: date('Y'),
        ];
    }
}
