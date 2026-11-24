<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Models\Media;
use App\Models\Page;
use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
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
            ->columns(3)
            ->components([
                Section::make('Текст страницы')
                    ->description('Здесь меняется только содержимое. Адрес страницы и разделы сайта задаёт разработчик.')
                    ->columnSpan(2)
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->label('Заголовок страницы'),
                        MarkdownEditor::make('content')
                            ->label('Текст страницы')
                            ->helperText('Обычный текст, # заголовок, **жирный**, - список. Пути к файлам писать вручную НЕ нужно: загрузите файл, сохраните страницу и нажмите кнопку «Вставить» ниже. Сырой HTML при публикации вырезается.')
                            ->columnSpanFull(),
                        Actions::make(fn (?Page $record): array => self::insertMediaActions($record))
                            ->label('Вставить файл в текст'),
                        Placeholder::make('media_buttons_hint')
                            ->label('')
                            ->content(new HtmlString(
                                'Загрузите картинку или PDF справа и нажмите «Сохранить» — здесь появятся кнопки с понятными названиями файлов этой страницы. '
                                .'Одно нажатие добавляет в текст готовую ссылку: ничего копировать, искать и переименовывать не надо. '
                                .'Картинки и PDF нужно вставить в текст кнопкой: картинка появится на месте ссылки, документ — мини-превью. '
                                .'Автоматических блоков со списками файлов внизу страницы и в «Просмотре» больше нет. '
                                .'Если нужный файл не появился в кнопках или картинка в тексте не отображается — откройте «Медиатеку» или выполните '
                                .'<code>php artisan media:check</code>: файл мог быть удалён или переименован после вставки. '
                                .'Ограничения загрузки: до 10 МБ, JPG/PNG/WebP/GIF/AVIF, SVG запрещён.'
                            ))
                            ->columnSpanFull(),
                        Placeholder::make('feed_hint')
                            ->label('')
                            ->content(new HtmlString(
                                '<strong>Лента новостей.</strong> Поле «Текст страницы» выше — это вступление. '
                                .'Ниже добавьте отдельные карточки: дата, заголовок, картинка, текст и ссылка. '
                                .'Порядок меняется перетаскиванием, лишний блок удаляется крестиком. '
                                .'Никакой разметки и путей файлов писать не нужно.'
                            ))
                            ->visible(fn (?Page $record): bool => $record !== null && $record->slug === 'news')
                            ->columnSpanFull(),
                        Repeater::make('blocks')
                            ->label('Лента новостей')
                            ->schema([
                                TextInput::make('date')
                                    ->label('Дата')
                                    ->placeholder('24.11.2026')
                                    ->maxLength(40),
                                TextInput::make('title')
                                    ->label('Заголовок')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(2),
                                FileUpload::make('image')
                                    ->label('Картинка (необязательно)')
                                    ->image()
                                    ->disk('public')
                                    ->directory('news')
                                    ->acceptedFileTypes([
                                        'image/jpeg',
                                        'image/png',
                                        'image/webp',
                                        'image/gif',
                                        'image/avif',
                                    ])
                                    ->maxSize(10240)
                                    ->deletable()
                                    ->deleteUploadedFileUsing(self::removeUploadedFile())
                                    ->columnSpanFull(),
                                Textarea::make('text')
                                    ->label('Текст новости')
                                    ->rows(4)
                                    ->helperText('Обычный текст. HTML не нужен и будет вырезан при публикации.')
                                    ->columnSpanFull(),
                                TextInput::make('link')
                                    ->label('Ссылка «Подробнее» (необязательно)')
                                    ->placeholder('/o-produkte/opisanie')
                                    ->helperText('Внутренняя ссылка вида /раздел или полный адрес https://…')
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                            ])
                            ->columns(3)
                            ->reorderable()
                            ->defaultItems(0)
                            ->itemLabel(fn (array $state): string => filled($state['title'] ?? null)
                                ? (string) $state['title']
                                : 'Новая запись')
                            ->addActionLabel('Добавить новость')
                            ->visible(fn (?Page $record): bool => $record !== null && $record->slug === 'news')
                            ->columnSpanFull(),
                    ]),
                Group::make([
                    Section::make('Картинки')
                        ->description('До 10 МБ на файл. Форматы: JPG, PNG, WebP, GIF, AVIF (SVG запрещён). Можно менять порядок. Имена значения не имеют: чтобы картинка появилась на странице, вставьте её в текст кнопкой.')
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
                                ->maxParallelUploads(1)
                                ->deletable()
                                ->deleteUploadedFileUsing(self::removeUploadedFile())
                                ->panelLayout('grid')
                                ->columnSpanFull(),
                        ]),
                    Section::make('Документы PDF')
                        ->description('После сохранения файлы появятся в кнопках «Вставить файл в текст». Отдельного списка PDF внизу страницы больше нет.')
                        ->schema([
                            FileUpload::make('documents')
                                ->label('PDF-документы')
                                ->multiple()
                                ->disk('public')
                                ->directory('documents')
                                ->acceptedFileTypes(['application/pdf'])
                                ->maxSize(20480)
                                ->maxParallelUploads(1)
                                ->deletable()
                                ->deleteUploadedFileUsing(self::removeUploadedFile())
                                ->openable()
                                ->downloadable()
                                ->columnSpanFull(),
                            Placeholder::make('documents_hint')
                                ->label('Как вставить документ в текст')
                                ->content(new HtmlString(
                                    'Загрузите PDF, сохраните страницу — и под редактором появится кнопка с названием документа. '
                                    .'Она вставит в текст готовую ссылку <code>/media/&lt;номер&gt;</code>, которая не зависит от имени файла. '
                                    .'В тексте ссылка автоматически станет мини-превью с просмотром на весь экран. '
                                    .'Никакие пути вручную писать и копировать не нужно; файлы, залитые по FTP, сайт не увидит.'
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
                                ->deleteUploadedFileUsing(self::removeUploadedFile())
                                ->columnSpanFull(),
                        ]),
                    Section::make('SEO')
                        ->schema([
                            TextInput::make('meta_description')
                                ->label('Meta description'),
                        ]),
                ])->columns(1)->columnSpan(1),
            ]);
    }

    /**
     * Кнопки вставки для файлов, уже зарегистрированных в медиатеке.
     * Менеджер видит человеческую подпись, а не ULID-имя, и не знает ни одного
     * пути. Нажатие дописывает готовый Markdown в поле `content`.
     *
     * Запрос обёрнут в rescue(): форма не должна падать, если миграция media
     * ещё не накатилась (например, админку открыли сразу после выкладки кода).
     *
     * @return array<int, Action>
     */
    private static function insertMediaActions(?Page $record): array
    {
        if ($record === null) {
            return [];
        }

        return rescue(
            static fn (): array => Media::query()
                ->where('page_id', $record->getKey())
                ->whereIn('collection', ['image', 'document'])
                ->latest()
                ->limit(24)
                ->get()
                // Не предлагаем файлы, которых нет на диске, иначе менеджер
                // вставит в текст заведомо битую картинку.
                ->filter(fn (Media $media): bool => $media->exists())
                ->map(fn (Media $media): Action => Action::make('insert_media_'.$media->getKey())
                    ->label(($media->collection === 'image' ? 'Картинка: ' : 'Документ: ').$media->displayName())
                    ->color('gray')
                    ->action(function (Get $get, Set $set) use ($media): void {
                        $content = trim((string) $get('content'));

                        $set('content', $content === ''
                            ? $media->markdown()
                            : $content."\n\n".$media->markdown());
                    }))
                ->all(),
            [],
            false,
        );
    }

    /**
     * Filament передаёт сюда и сохранённый путь (string), и ещё не сохранённый
     * TemporaryUploadedFile. Строгий тип `string` в колбэке вызывал TypeError и
     * молча срывал удаление, поэтому тип не объявлен, а оба варианта
     * обрабатываются явно. Штатные имена файлов (ULID) генерирует сам Filament.
     */
    private static function removeUploadedFile(): Closure
    {
        return static function (mixed $file): void {
            if ($file instanceof TemporaryUploadedFile) {
                $file->delete();

                return;
            }

            if (is_string($file) && filled($file)) {
                Storage::disk('public')->delete($file);
            }
        };
    }
}
