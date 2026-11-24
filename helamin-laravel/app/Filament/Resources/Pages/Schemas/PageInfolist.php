<?php

namespace App\Filament\Resources\Pages\Schemas;

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
            ]);
    }
}
