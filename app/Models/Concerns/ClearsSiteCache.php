<?php

namespace App\Models\Concerns;

use App\Services\SiteContentService;

trait ClearsSiteCache
{
    protected static function bootClearsSiteCache(): void
    {
        static::saved(fn () => SiteContentService::flushCache());
        static::deleted(fn () => SiteContentService::flushCache());
    }
}
