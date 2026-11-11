<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use ClearsSiteCache;

    protected $fillable = [
        'headline', 'quote', 'student_name', 'student_batch', 'avatar', 'rating',
        'is_active', 'sort_order',
    ];

    protected $casts = ['is_active' => 'boolean'];
}
