<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MockTestQuestion extends Model
{
    use ClearsSiteCache;

    protected $fillable = [
        'subject', 'question', 'options', 'correct_option',
        'explanation', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean',
    ];

    public function mockTest(): BelongsTo
    {
        return $this->belongsTo(MockTest::class);
    }
}
