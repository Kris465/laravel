<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Models\Page;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class PageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Информация о странице')
                    ->schema([
                        TextEntry::make('slug')
                            ->label('URL (slug)'),
                        TextEntry::make('title')
                            ->label('Заголовок'),
                        TextEntry::make('is_active')
                            ->label('Активна')
                            ->formatStateUsing(fn ($state) => $state ? 'Да' : 'Нет'),
                    ]),
                Section::make('SEO')
                    ->schema([
                        TextEntry::make('meta_description')
                            ->label('Meta description'),
                    ]),
                Section::make('Контент')
                    ->schema([
                        TextEntry::make('content')
                            ->label('')
                            ->html()
                            ->formatStateUsing(fn ($state) => new HtmlString(Str::markdown($state ?? '', [
                                'html_input' => 'strip',
                                'allow_unsafe_links' => false,
                            ]))),
                    ]),
                Section::make('Картинки — готовые ссылки')
                    ->description('Вставьте в текст: ![Описание картинки](/storage/images/...). Все загруженные картинки сразу видны галереей под текстом — удобно перебрать несколько вариантов.')
                    ->schema([
                        TextEntry::make('images')
                            ->label('')
                            ->html()
                            ->formatStateUsing(function ($state) {
                                if (empty($state)) {
                                    return 'Картинки не загружены';
                                }

                                return new HtmlString(collect($state)->map(function (string $path) {
                                    $url = Page::mediaUrl($path);
                                    $name = basename($path);

                                    return '<code>!['.e($name).']('.e($url).')</code>';
                                })->implode('<br>'));
                            }),
                    ]),
                Section::make('Готовые ссылки на документы')
                    ->description('Скопируйте ссылку и вставьте её в текст страницы: [Название документа](ссылка). Пробелы и кириллица в ссылке уже экранированы.')
                    ->schema([
                        TextEntry::make('documents')
                            ->label('')
                            ->html()
                            ->formatStateUsing(function ($state) {
                                if (empty($state)) {
                                    return 'Документы не загружены';
                                }

                                return new HtmlString(collect($state)->map(function (string $path) {
                                    $url = Page::mediaUrl($path);
                                    $name = basename($path);

                                    return '<code>['.e($name).']('.e($url).')</code>';
                                })->implode('<br>'));
                            }),
                    ]),
            ]);
    }
}
