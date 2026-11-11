<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use Illuminate\Database\Eloquent\Model;

class ElibraryResource extends Model
{
    use ClearsSiteCache;

    protected $fillable = [
        'slug', 'title', 'category', 'exam_category', 'category_name', 'subject',
        'badge', 'format', 'pages', 'size', 'downloads', 'rating', 'image',
        'description', 'file_name', 'file_path', 'is_active', 'sort_order',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function toFrontendArray(): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'category' => $this->category,
            'exam_category' => $this->exam_category,
            'category_name' => $this->category_name,
            'subject' => $this->subject,
            'badge' => $this->badge,
            'format' => $this->format,
            'pages' => $this->pages,
            'size' => $this->size,
            'downloads' => $this->downloads,
            'rating' => $this->rating,
            'image' => $this->image ?: 'frontend/img/course/course1-1.jpg',
            'description' => $this->description,
            'file_name' => $this->file_name ?: ($this->slug . '.pdf'),
            'file_path' => $this->file_path,
        ];
    }
}
