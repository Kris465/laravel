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
    ];

    protected $casts = [
        'is_active' => 'boolean',
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
}
