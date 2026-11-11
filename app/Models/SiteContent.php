<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use Illuminate\Database\Eloquent\Model;

class SiteContent extends Model
{
    use ClearsSiteCache;

    protected $fillable = ['section', 'key', 'label', 'type', 'value', 'sort_order'];
}
