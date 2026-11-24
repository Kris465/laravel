<?php

use App\Models\Media;
use App\Models\Page;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
 * Разовая регистрация файлов, загруженных до появления медиатеки.
 * Без этой команды старые картинки/PDF останутся без стабильных /media/{id}.
 */
Artisan::command('media:sync', function () {
    $total = 0;

    Page::query()->each(function (Page $page) use (&$total): void {
        $total += Media::syncForPage($page);
    });

    $this->info("Зарегистрировано файлов в медиатеке: {$total}");
})->purpose('Register already uploaded page files in the media library');

/*
 * Диагностика: почему картинка/PDF не открываются. Показывает все записи
 * медиатеки, нашёлся ли файл на диске, его MIME/размер, а также все ссылки
 * на файлы в текстах страниц и результат их проверки.
 */
Artisan::command('media:check', function () {
    $rows = [];

    Media::query()->orderBy('id')->each(function (Media $media) use (&$rows): void {
        $resolved = $media->resolveExistingPath();

        $rows[] = [
            $media->getKey(),
            $media->collection,
            $media->path,
            $media->file_path ?: '—',
            $resolved === null ? '⚠ НЕ НАЙДЕН' : '✓ найден',
            $resolved === null ? '—' : (string) ($media->mime ?: '—'),
            $resolved === null ? '—' : number_format((int) $media->size / 1024, 1).' КБ',
            '/media/'.$media->getKey(),
        ];
    });

    $this->table(['ID', 'Тип', 'Якорь', 'Файл', 'Статус', 'MIME', 'Размер', 'Ссылка'], $rows);

    $problems = [];
    $disk = Storage::disk('public');

    Page::query()->orderBy('id')->each(function (Page $page) use (&$problems, $disk): void {
        preg_match_all(
            '~\((/media/(\d+)|/storage/([^\s)]+))\)~u',
            (string) ($page->content ?? ''),
            $matches,
            PREG_SET_ORDER,
        );

        foreach ($matches as $match) {
            if (($match[2] ?? '') !== '') {
                $media = Media::find((int) $match[2]);
                $ok = $media !== null && $media->resolveExistingPath() !== null;
                $result = $ok ? 'OK' : 'БИТАЯ: нет записи или файла';
            } else {
                $path = implode('/', array_map('rawurldecode', explode('/', $match[3])));
                $result = $disk->exists($path)
                    ? 'OK (напрямую /storage)'
                    : 'БИТАЯ: файла нет на диске';
            }

            $problems[] = [$page->slug, $match[1], $result];
        }
    });

    if ($problems === []) {
        $this->info('Ссылок на файлы в текстах страниц не найдено.');
    } else {
        $this->table(['Страница', 'Ссылка в тексте', 'Результат'], $problems);
    }

    $this->line('Подсказка: битые /media/{id} чинятся в /admin/media (поле «Фактический путь файла»).');

    return 0;
})->purpose('Diagnose media records and file links in page content');
