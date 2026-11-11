<?php

namespace App\Providers;

use App\Services\SiteContentService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (request()->server('HTTP_X_FORWARDED_PROTO') === 'https' || request()->isSecure() || app()->environment('production')) {
            URL::forceScheme('https');
        }

        View::composer('frontend.*', function ($view) {
            $view->with('cms', SiteContentService::getSettings());
        });
    }
}
