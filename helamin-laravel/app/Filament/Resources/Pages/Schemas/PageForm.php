<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class PageForm
{
    /**
     * Менеджеры редактируют только контент: URL, тип страницы, активность
     * и набор страниц задаются routes/web.php и PageSeeder.
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Текст страницы')
                    ->description('Здесь меняется только содержимое. Адрес страницы и разделы сайта задаёт разработчик.')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->label('Заголовок страницы'),
                        MarkdownEditor::make('content')
                            ->label('Текст страницы')
                            ->helperText('Markdown: # заголовок, **жирный**, - список, [текст ссылки](/адрес). Сырой HTML при публикации вырезается.')
                            ->columnSpanFull(),
                    ]),
                Section::make('Картинки')
                    ->description('Можно выбрать сразу несколько файлов и менять их порядок. Форматы: JPG, PNG, WebP, GIF, AVIF. SVG запрещён из соображений безопасности.')
                    ->schema([
                        FileUpload::make('images')
                            ->label('Картинки')
                            ->multiple()
                            ->reorderable()
                            ->image()
                            ->disk('public')
                            ->directory('images')
                            ->acceptedFileTypes([
                                'image/jpeg',
                                'image/png',
                                'image/webp',
                                'image/gif',
                                'image/avif',
                            ])
                            ->maxSize(10240)
                            ->panelLayout('grid')
                            ->columnSpanFull(),
                    ]),
                Section::make('Документы PDF')
                    ->description('Файлы складываются в папку documents и доступны посетителям для скачивания.')
                    ->schema([
                        FileUpload::make('documents')
                            ->label('PDF-документы')
                            ->multiple()
                            ->disk('public')
                            ->directory('documents')
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(20480)
                            ->preserveFilenames()
                            ->openable()
                            ->downloadable()
                            ->columnSpanFull(),
                        Placeholder::make('documents_hint')
                            ->label('Как вставить ссылку на документ в текст')
                            ->content(new HtmlString(
                                'Загрузите PDF, сохраните страницу — в разделе «Просмотр» появятся готовые ссылки. '.
                                'В тексте напишите, например: <code>[Скачать паспорт безопасности](/storage/documents/passport.pdf)</code>. '.
                                'Посетитель скачает документ, нажав на слова ссылки. Все загруженные PDF также выводятся списком под текстом страницы.'
                            ))
                            ->columnSpanFull(),
                    ]),
                Section::make('SEO')
                    ->schema([
                        TextInput::make('meta_description')
                            ->label('Meta description')
                            ->columnStart(1),
                    ]),
            ]);
    }
}
