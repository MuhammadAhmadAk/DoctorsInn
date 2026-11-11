<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use ClearsSiteCache;

    protected $fillable = ['question', 'answer', 'category', 'show_on_home', 'is_active', 'sort_order'];

    protected $casts = [
        'show_on_home' => 'boolean',
        'is_active' => 'boolean',
    ];
}
