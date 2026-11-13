<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Models\Page;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

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
                            ->deletable()
                            ->deleteUploadedFileUsing(static fn (string $file) => Storage::disk('public')->delete($file))
                            ->getUploadedFileNameForStorageUsing(static fn (TemporaryUploadedFile $file): string => self::safeFileName($file))
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
                            ->deletable()
                            ->deleteUploadedFileUsing(static fn (string $file) => Storage::disk('public')->delete($file))
                            ->getUploadedFileNameForStorageUsing(static fn (TemporaryUploadedFile $file): string => self::safeFileName($file))
                            ->openable()
                            ->downloadable()
                            ->columnSpanFull(),
                        Placeholder::make('documents_hint')
                            ->label('Как вставить ссылку на документ в текст')
                            ->content(new HtmlString(
                                'Загрузите файлы и сохраните страницу — в разделе «Просмотр» появятся готовые, уже экранированные ссылки. '.
                                'Документ в тексте: <code>[Скачать паспорт](/storage/documents/passport.pdf)</code>, '.
                                'картинка: <code>![Описание картинки](/storage/images/photo.jpg)</code>. '.
                                'Имена файлов можно писать с пробелами и по-русски — ссылка всё равно будет корректной. '.
                                'Все загруженные PDF выводятся списком под текстом, а картинки — галереей; при желании их можно дополнительно вставить прямо в текст.'
                            ))
                            ->columnSpanFull(),
                    ]),
                Section::make('Фон сайта')
                    ->description('Картинка ложится плиткой на светлую область всех страниц. Загрузите новый вариант — и фон сразу сменится; можно перебирать сколько угодно.')
                    ->visible(fn (?Page $record): bool => $record !== null && $record->type === 'home')
                    ->schema([
                        FileUpload::make('background')
                            ->label('Картинка фона')
                            ->image()
                            ->disk('public')
                            ->directory('backgrounds')
                            ->acceptedFileTypes([
                                'image/jpeg',
                                'image/png',
                                'image/webp',
                                'image/gif',
                                'image/avif',
                            ])
                            ->maxSize(10240)
                            ->deletable()
                            ->deleteUploadedFileUsing(static fn (string $file) => Storage::disk('public')->delete($file))
                            ->getUploadedFileNameForStorageUsing(static fn (TemporaryUploadedFile $file): string => self::safeFileName($file))
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

    /**
     * Читаемое, но безопасное имя: пробелы/кириллица превращаются в slug,
     * ULID гарантирует уникальность (иначе повторная загрузка перезапишет файл,
     * а удаление «залипнет»), расширение берётся из исходного файла.
     */
    private static function safeFileName(TemporaryUploadedFile $file): string
    {
        $base = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) ?: 'file';

        return $base.'-'.Str::lower(Str::ulid()).'.'.$file->getClientOriginalExtension();
    }
}
