<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddSecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Livewire/Filament используют inline-скрипты, поэтому строгая политика
        // применяется только к публичной части сайта. Файлы медиатеки (/media/*)
        // исключены: их встраивают в <iframe> для мини-превью PDF, а заголовки
        // frame-ancestors 'none' и X-Frame-Options запретили бы это.
        if ($request->is('admin', 'admin/*', 'filament/*', 'livewire/*', 'storage/*', 'media/*', 'up')) {
            return $response;
        }

        $response->headers->set('Content-Security-Policy', implode('; ', [
            "default-src 'self'",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-ancestors 'none'",
            "script-src 'self'",
            "style-src 'self' 'unsafe-inline'",
            "img-src 'self' data:",
            "font-src 'self'",
            "object-src 'none'",
        ]));
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        return $response;
    }
}
