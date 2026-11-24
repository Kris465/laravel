<?php

namespace App\Providers;

use App\Models\Media;
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

            if (! filled($path)) {
                $view->with('siteBackgroundUrl', null);

                return;
            }

            // /storage/... требует, чтобы веб-сервер ходил по симлинку
            // public/storage. На этом хостинге статика по симлинку не отдаётся,
            // поэтому предпочитаем /media/{id}: MediaController отдаёт файл
            // напрямую из Storage с явным MIME, без симлинка и правил nginx.
            // Fallback сохраняем для фонов, ещё не зарегистрированных в медиатеке.
            $media = rescue(
                fn (): ?Media => Media::query()
                    ->where('path', $path)
                    ->where('collection', 'background')
                    ->first(),
                null,
                false,
            );

            $view->with('siteBackgroundUrl', $media ? $media->url() : Page::mediaUrl($path));
        });
    }
}
