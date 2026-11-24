<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MediaController extends Controller
{
    /**
     * Явно задаём MIME по расширению. Storage::response() определяет тип по
     * содержимому через fileinfo, а на некоторых хостингах (и на Windows)
     * WebP/AVIF определяются как application/octet-stream — браузер тогда
     * не показывает картинку в <img>, хотя файл отдан успешно.
     */
    private const MIME_BY_EXTENSION = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'webp' => 'image/webp',
        'gif' => 'image/gif',
        'avif' => 'image/avif',
        'pdf' => 'application/pdf',
    ];

    /**
     * Вечные ссылки /media/{id}: физический путь берётся из БД, поэтому
     * переименование файла на хостинге не ломает ни текст, ни галерею.
     *
     * Файл отдаётся напрямую из хранилища, а не редиректом на /storage/...:
     * так картинка/PDF не зависят от симлинка public/storage, APP_URL и от
     * точного имени файла, а PDF можно встраивать в <iframe> для превью.
     *
     * Отдельный контроллер (а не замыкание в routes/web.php) нужен, чтобы
     * `php artisan route:cache` из deploy.sh работал без ошибок.
     */
    public function show(Media $media): StreamedResponse
    {
        $path = $media->resolveExistingPath();

        if ($path === null) {
            Log::warning('Media file not found', [
                'media_id' => $media->getKey(),
                'path' => $media->path,
                'file_path' => $media->file_path,
            ]);

            abort(404, 'Файл не найден. Проверьте путь в разделе «Медиатека» админки.');
        }

        // inline: браузер показывает картинку/PDF, а не скачивает. Ссылки
        // со скачиванием в галерее всё равно имеют атрибут download.
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $headers = isset(self::MIME_BY_EXTENSION[$extension])
            ? ['Content-Type' => self::MIME_BY_EXTENSION[$extension]]
            : [];

        return $media->storageDisk()->response($path, null, $headers, 'inline');
    }
}
