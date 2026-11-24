<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class Page extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'content',
        'blocks',
        'meta_description',
        'type',
        'is_active',
        'images',
        'documents',
        'background',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'images' => 'array',
        'documents' => 'array',
        'blocks' => 'array',
    ];

    /**
     * Последняя линия защиты: даже если где-то останется кнопка удаления
     * или кто-то вызовет delete() из консоли, главная страница не исчезнет.
     */
    protected static function booted(): void
    {
        static::deleting(static fn (self $page): bool => $page->slug !== '/');
    }

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
        $html = Str::markdown($this->stabilizedContent(), [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        return new HtmlString($this->decorateDocumentLinks($html));
    }

    /**
     * Отдельного списка файлов внизу страницы больше нет. Ссылку на PDF,
     * которую менеджер вставил в текст кнопкой (/media/{id}), превращаем
     * в мини-превью с просмотром на весь экран прямо на месте ссылки.
     * Ссылки на картинки и обычные страницы не затрагиваются.
     */
    private function decorateDocumentLinks(string $html): string
    {
        if (! str_contains($html, '/media/')) {
            return $html;
        }

        preg_match_all('~<a\s+href="(/media/(\d+))"[^>]*>(.*?)</a>~su', $html, $matches, PREG_SET_ORDER);

        if ($matches === []) {
            return $html;
        }

        $ids = array_values(array_unique(array_map(
            static fn (array $match): int => (int) $match[2],
            $matches,
        )));

        $documents = Media::query()
            ->whereIn('id', $ids)
            ->where('collection', 'document')
            ->get()
            ->keyBy('id');

        if ($documents->isEmpty()) {
            return $html;
        }

        $replacements = [];

        foreach ($matches as $match) {
            $media = $documents->get((int) $match[2]);

            if (! $media) {
                continue;
            }

            $name = trim(strip_tags($match[3])) ?: $media->displayName();
            $url = e($match[1]);
            $safeName = e($name);

            $replacements[$match[0]] = '<span class="pdf-card pdf-card--inline"'
                .' data-pdf-url="'.$url.'" data-pdf-name="'.$safeName.'">'
                .'<a class="pdf-card__preview" href="'.$url.'" title="Открыть '.$safeName.' на весь экран">'
                .'<span class="pdf-card__fallback">PDF<span>Документ</span></span>'
                .'<iframe class="pdf-card__frame" src="'.$url.'#toolbar=0&amp;navpanes=0&amp;scrollbar=0&amp;view=FitH"'
                .' title="Превью: '.$safeName.'" loading="lazy" tabindex="-1"></iframe>'
                .'<span class="pdf-card__zoom" aria-hidden="true">⤢</span>'
                .'</a>'
                .'<span class="pdf-card__body">'
                .'<span class="pdf-card__name" title="'.$safeName.'">'.$safeName.'</span>'
                .'<a class="pdf-card__download" href="'.$url.'" download>Скачать PDF</a>'
                .'</span>'
                .'</span>';
        }

        return $replacements === [] ? $html : strtr($html, $replacements);
    }

    /**
     * Старые тексты менеджеров содержат прямые ссылки /storage/<имя файла>.
     * Подменяем их на вечные /media/{id} для всех зарегистрированных файлов,
     * чтобы уже набранный контент пережил переименование файла на хостинге.
     * Незарегистрированные /storage/... остаются как есть (обратная совместимость).
     */
    public function stabilizedContent(): string
    {
        $content = $this->content ?? '';

        if (! str_contains($content, '/storage/')) {
            return $content;
        }

        preg_match_all('~/storage/([^\s)]+)~u', $content, $matches);

        $paths = array_values(array_unique(array_filter(
            array_map(
                static fn (string $encoded): string => implode('/', array_map('rawurldecode', explode('/', $encoded))),
                $matches[1] ?? [],
            ),
        )));

        if ($paths === []) {
            return $content;
        }

        $map = Media::query()
            ->whereIn('path', $paths)
            ->get()
            ->mapWithKeys(fn (Media $media): array => [self::mediaUrl($media->path) => $media->url()]);

        return $map->isEmpty()
            ? $content
            : str_replace($map->keys()->all(), $map->values()->all(), $content);
    }

    /**
     * Блоки ленты новостей, подготовленные к безопасному выводу.
     * Пустые блоки отбрасываются, текст проходит ту же санитизацию, что и
     * основное содержимое, картинки резолвятся через медиатеку (/media/{id}),
     * а внешние ссылки — только по белому списку протоколов.
     *
     * @return array<int, array{title: string, date: string, text: HtmlString, image: ?string, link: ?string}>
     */
    public function feedBlocks(): array
    {
        $media = $this->mediaByPath();

        return collect(self::ensureArray($this->blocks ?? null))
            ->filter(static fn ($block): bool => is_array($block)
                && (trim((string) ($block['title'] ?? '')) !== '' || trim((string) ($block['text'] ?? '')) !== ''))
            ->map(function (array $block) use ($media): array {
                $image = $block['image'] ?? null;

                return [
                    'title' => trim((string) ($block['title'] ?? '')),
                    'date' => trim((string) ($block['date'] ?? '')),
                    'text' => new HtmlString(Str::markdown(trim((string) ($block['text'] ?? '')), [
                        'html_input' => 'strip',
                        'allow_unsafe_links' => false,
                    ])),
                    'image' => is_string($image) && $image !== ''
                        ? ($media->get(ltrim($image, '/'))?->url() ?? self::mediaUrl($image))
                        : null,
                    'link' => self::safeUrl(trim((string) ($block['link'] ?? ''))),
                ];
            })
            ->values()
            ->all();
    }

    /** Разрешаем только относительные, http(s) и mailto-ссылки. */
    private static function safeUrl(string $url): ?string
    {
        if ($url === '' || preg_match('/[\r\n]/', $url)) {
            return null;
        }

        if (str_starts_with($url, '/') || str_starts_with($url, '#')) {
            return $url;
        }

        return preg_match('~^(https?://|mailto:)~i', $url) ? $url : null;
    }

    /** @return Collection<string, Media> */
    public function mediaByPath(): Collection
    {
        return Media::query()
            ->where('page_id', $this->getKey())
            ->get()
            ->keyBy('path');
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

    /**
     * Старые/битые записи могут хранить одиночное значение строкой вместо
     * массива. Нормализуем к массиву, чтобы whereIn()/collect() не падали
     * с TypeError: count(): Argument #1 must be of type Countable|array.
     */
    public static function ensureArray(mixed $value): array
    {
        if (is_array($value)) {
            return array_values($value);
        }

        if (is_string($value) && trim($value) !== '') {
            return [$value];
        }

        return [];
    }

    /** @return array<int, string> */
    public static function ensurePathList(mixed $value): array
    {
        return array_values(array_filter(self::ensureArray($value), 'is_string'));
    }

    /** @return array<int, string> */
    public function imageUrls(): array
    {
        $media = $this->mediaByPath();

        return collect(self::ensurePathList($this->images ?? null))
            ->map(function (string $path) use ($media): string {
                $item = $media->get(ltrim($path, '/'));

                return $item ? $item->url() : self::mediaUrl($path);
            })
            ->all();
    }

    /** @return array<int, array{name: string, url: string}> */
    public function documentLinks(): array
    {
        $media = $this->mediaByPath();

        return collect(self::ensurePathList($this->documents ?? null))
            ->map(function (string $path) use ($media): array {
                $item = $media->get(ltrim($path, '/'));

                return [
                    'name' => $item ? $item->displayName() : basename($path),
                    'url' => $item ? $item->url() : self::mediaUrl($path),
                ];
            })
            ->all();
    }
}
