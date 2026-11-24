<?php

namespace App\Filament\Resources\Media\Tables;

use App\Models\Media;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MediaTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('label')
                    ->label('Название')
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('collection')
                    ->label('Тип')
                    ->badge(),
                TextColumn::make('file_path')
                    ->label('Файл на диске')
                    ->searchable()
                    ->limit(40)
                    ->formatStateUsing(fn (?string $state, Media $record): string => ($record->exists() ? '✓ ' : '⚠ нет файла: ').($state ?: '—'))
                    ->color(fn (Media $record): string => $record->exists() ? 'success' : 'danger'),
                TextColumn::make('updated_at')
                    ->label('Обновлён')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->defaultSort('id', 'desc');
    }
}
