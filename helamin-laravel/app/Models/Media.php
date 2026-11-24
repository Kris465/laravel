<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Медиатека: один файл = одна запись с неизменным ID.
 *
 * Раньше ссылка в тексте страницы была буквальным путём к файлу
 * (/storage/images/<имя>.jpg). Хостинг переименовывал файл — и текст,
 * галерея и список PDF одновременно «отваливались». Теперь в контенте
 * фигурирует только /media/{id}.
 *
 * `path` — неизменный якорь (первоначальный путь): по нему находятся старые
 * ссылки и записи в pages.images/documents. `file_path` — реальное положение
 * файла на диске; именно его правят при переименовании. Тексты при этом не
 * трогаются вообще.
 */
class Media extends Model
{
    protected $fillable = [
        'page_id',
        'disk',
        'path',
        'file_path',
        'collection',
        'label',
        'mime',
        'size',
    ];

    /** Поле страницы => тип файла в медиатеке. */
    public const COLLECTIONS = [
        'images' => 'image',
        'documents' => 'document',
        'background' => 'background',
    ];

    /** Вечная ссылка, не зависящая от имени файла. */
    public function url(): string
    {
        return route('media.show', $this);
    }

    /** Файл, на который сейчас указывает запись. */
    public function currentPath(): string
    {
        return $this->file_path ?: $this->path;
    }

    /** Текущий физический URL (используется только внутри редиректа). */
    public function storageUrl(): string
    {
        return Page::mediaUrl($this->currentPath());
    }

    public function displayName(): string
    {
        return $this->label ?: basename($this->currentPath());
    }

    public function storageDisk()
    {
        return Storage::disk($this->disk ?: 'public');
    }

    /** Есть ли файл на диске по одному из известных путей (без автопоиска). */
    public function exists(): bool
    {
        return $this->resolveExistingPath(allowDiscovery: false) !== null;
    }

    /**
     * Возвращает реально существующий путь к файлу.
     *
     * Хостинг часто переименовывает загруженные файлы (транслит, `_1`, регистр),
     * сохраняя ULID-префикс. Если по `file_path` и по якорю `path` файла нет,
     * ищем в той же папке единственный файл с тем же префиксом и расширением
     * и запоминаем новый `file_path`. Тексты страниц и /media/{id} не меняются.
     */
    public function resolveExistingPath(bool $allowDiscovery = true): ?string
    {
        $disk = $this->storageDisk();

        foreach (array_unique(array_filter([$this->file_path, $this->path])) as $candidate) {
            if ($disk->exists($candidate)) {
                return $candidate;
            }
        }

        if (! $allowDiscovery) {
            return null;
        }

        $anchor = ltrim((string) $this->path, '/');
        $directory = dirname($anchor);
        $stem = pathinfo($anchor, PATHINFO_FILENAME);
        $extension = strtolower(pathinfo($anchor, PATHINFO_EXTENSION));

        if ($stem === '' || $extension === '') {
            return null;
        }

        $candidates = rescue(
            static fn (): array => collect($disk->files($directory === '.' ? '' : $directory))
                ->filter(static fn (string $file): bool => str_starts_with(basename($file), $stem)
                    && strtolower(pathinfo($file, PATHINFO_EXTENSION)) === $extension)
                ->values()
                ->all(),
            [],
            false,
        );

        // Обновляем путь только при однозначном совпадении, чтобы не подменить
        // файл «наугад». В остальных случаях поможет раздел «Медиатека».
        if (count($candidates) !== 1) {
            return null;
        }

        $this->file_path = $candidates[0];
        $this->save();

        return $this->file_path;
    }

    /** Готовая Markdown-вставка для кнопки «Вставить в текст». */
    public function markdown(): string
    {
        $fallback = $this->collection === 'image'
            ? 'Описание картинки'
            : 'Название документа';

        $name = $this->label ?: $fallback;

        return $this->collection === 'image'
            ? '!['.$name.']('.$this->url().')'
            : '['.$name.']('.$this->url().')';
    }

    /**
     * Регистрирует файлы, уже прикреплённые к странице. Вызывается после
     * сохранения формы в админке и разово командой `php artisan media:sync`
     * (чтобы получить ID файлы, загруженные до обновления сайта).
     *
     * @return int число обработанных файлов
     */
    public static function syncForPage(Page $page): int
    {
        $count = 0;
        $pageId = (int) $page->getKey();

        foreach (self::COLLECTIONS as $field => $collection) {
            $value = $page->{$field};

            $paths = $field === 'background'
                ? array_filter([is_string($value) ? $value : null])
                : Page::ensurePathList($value);

            foreach ($paths as $path) {
                if (static::registerPath($path, $collection, $pageId)) {
                    $count++;
                }
            }
        }

        // Картинки из блоков ленты новостей тоже получают стабильные /media/{id}.
        foreach (Page::ensureArray($page->blocks ?? null) as $block) {
            if (! is_array($block)) {
                continue;
            }

            $image = $block['image'] ?? null;
            $paths = is_array($image) ? $image : [$image];

            foreach (array_filter($paths, 'is_string') as $path) {
                if (static::registerPath($path, 'image', $pageId)) {
                    $count++;
                }
            }
        }

        return $count;
    }

    private static function registerPath(string $rawPath, string $collection, int $pageId): bool
    {
        $path = ltrim($rawPath, '/');

        if ($path === '') {
            return false;
        }

        $media = static::firstOrNew(['path' => $path]);

        $media->fill([
            'page_id' => $pageId,
            'disk' => 'public',
            'collection' => $collection,
        ]);

        // file_path и label не перезаписываем, если они уже заданы:
        // это правка администратора после переименования файла и
        // человеческая подпись менеджера. NULL заполняем якорем.
        if (! filled($media->file_path)) {
            $media->file_path = $path;
        }

        // Метаданные необязательны: если файл уже переименован или
        // временно отсутствует, запись всё равно должна создаться.
        $currentPath = $media->currentPath();
        $mime = rescue(fn () => Storage::disk('public')->mimeType($currentPath), null, false);
        $size = rescue(fn () => Storage::disk('public')->size($currentPath), null, false);

        if (filled($mime)) {
            $media->mime = $mime;
        }

        if (filled($size)) {
            $media->size = $size;
        }

        return $media->save();
    }
}
