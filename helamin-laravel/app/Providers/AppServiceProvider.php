<?php

namespace App\Providers;

use App\Models\Page;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('layouts.app', function ($view): void {
            $path = rescue(
                fn () => Page::query()->where('slug', '/')->where('is_active', true)->value('background'),
                null,
                false,
            );

            $view->with('siteBackgroundUrl', $path ? Page::mediaUrl($path) : null);
        });
    }
}
