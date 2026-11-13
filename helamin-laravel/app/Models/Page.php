<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class Page extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'content',
        'meta_description',
        'type',
        'is_active',
        'images',
        'documents',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'images' => 'array',
        'documents' => 'array',
    ];

    public static function getBySlug(string $slug): ?self
    {
        return static::where('slug', $slug)->where('is_active', true)->first();
    }

    /**
     * Контент хранится в Markdown. Сырой HTML вырезается, опасные ссылки
     * (javascript:, data:) блокируются — сайт восстанавливался после JS-инъекции.
     */
    public function renderedContent(): HtmlString
    {
        return new HtmlString(Str::markdown($this->content ?? '', [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]));
    }

    /**
     * Относительный URL медиа с посегментным экранированием: пробелы и кириллица
     * в именах файлов не ломают ни <img>, ни Markdown-ссылку. Относительный путь
     * важен: Storage::url() подставляет APP_URL и на локальном сервере указывает
     * не на тот хост.
     */
    public static function mediaUrl(string $path): string
    {
        $segments = explode('/', ltrim($path, '/'));

        return '/storage/'.implode('/', array_map(
            static fn (string $segment): string => rawurlencode($segment),
            $segments,
        ));
    }

    /** @return array<int, string> */
    public function imageUrls(): array
    {
        return collect($this->images ?? [])
            ->map(fn (string $path): string => self::mediaUrl($path))
            ->all();
    }

    /** @return array<int, array{name: string, url: string}> */
    public function documentLinks(): array
    {
        return collect($this->documents ?? [])
            ->map(fn (string $path): array => [
                'name' => basename($path),
                'url' => self::mediaUrl($path),
            ])
            ->all();
    }
}
