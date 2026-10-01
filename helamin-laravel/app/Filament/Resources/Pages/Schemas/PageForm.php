<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Основная информация')
                    ->schema([
                        TextInput::make('slug')
                            ->required()
                            ->unique('pages', 'slug', ignoreRecord: true)
                            ->label('URL (slug)')
                            ->placeholder('/ или /o-produkte/opisanie'),
                        TextInput::make('title')
                            ->required()
                            ->label('Заголовок страницы'),
                        Select::make('type')
                            ->required()
                            ->label('Тип страницы')
                            ->options([
                                'home' => 'Главная (с hero-блоком)',
                                'simple' => 'Простая страница',
                            ])
                            ->default('simple'),
                        RichEditor::make('content')
                            ->label('Контент')
                            ->columnSpanFull(),
                    ]),
                Section::make('SEO')
                    ->schema([
                        TextInput::make('meta_description')
                            ->label('Meta description')
                            ->columnStart(1),
                    ]),
                Section::make('Настройки')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Страница активна'),
                    ]),
            ]);
    }
}
