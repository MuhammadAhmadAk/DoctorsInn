<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use ClearsSiteCache;

    protected $fillable = [
        'name', 'designation', 'bio', 'image', 'rating',
        'facebook_url', 'twitter_url', 'linkedin_url', 'instagram_url',
        'is_active', 'sort_order',
    ];

    protected $casts = ['is_active' => 'boolean'];
}
