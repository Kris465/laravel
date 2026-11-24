<?php

namespace App\Filament\Resources\Media\Schemas;

use App\Models\Media;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class MediaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Файл')
                ->description('Здесь меняется только подпись и фактическое расположение файла. Ссылки на страницах остаются прежними.')
                ->schema([
                    Placeholder::make('stable_link')
                        ->label('Ссылка на сайте (не меняется)')
                        ->content(fn (?Media $record): HtmlString => new HtmlString(
                            $record ? '<code>/media/'.$record->getKey().'</code>' : '—'
                        )),
                    Placeholder::make('path_view')
                        ->label('Якорь (не менять)')
                        ->content(fn (?Media $record): string => $record?->path ?? '—'),
                    Placeholder::make('file_status')
                        ->label('Статус файла')
                        ->content(function (?Media $record): HtmlString {
                            if (! $record) {
                                return new HtmlString('—');
                            }

                            return new HtmlString($record->exists()
                                ? '<span style="color:#059669">✓ Файл найден — картинка и превью PDF работают.</span>'
                                : '<span style="color:#dc2626">⚠ Файл не найден. Хостинг мог переименовать его — поправьте «Фактический путь файла» ниже. '
                                .'Если файл был удалён из формы, загрузите его заново на страницу и вставьте новую ссылку: старую /media/'.$record->getKey().' из текста нужно удалить.</span>');
                        }),
                    TextInput::make('label')
                        ->label('Название для кнопки вставки')
                        ->helperText('Например «Паспорт безопасности» или «Фото котла». Именно это увидят менеджеры в форме страницы.')
                        ->maxLength(255),
                    TextInput::make('file_path')
                        ->label('Фактический путь файла')
                        ->helperText('Если хостинг переименовал файл — впишите сюда новое имя (например images/kotel_1.jpg). Тексты страниц править НЕ нужно.')
                        ->required()
                        ->maxLength(255),
                ]),
        ]);
    }
}
