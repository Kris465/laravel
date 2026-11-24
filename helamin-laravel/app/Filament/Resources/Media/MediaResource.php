<?php

namespace App\Filament\Resources\Media;

use App\Filament\Resources\Media\Pages\EditMedia;
use App\Filament\Resources\Media\Pages\ListMedia;
use App\Filament\Resources\Media\Schemas\MediaForm;
use App\Filament\Resources\Media\Tables\MediaTable;
use App\Models\Media;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

/**
 * Медиатека для администратора: подписи файлов и исправление путей после
 * переименования на хостинге. Создание/удаление запрещено — записи появляются
 * только при загрузке файлов на страницах, иначе ссылки /media/{id} пропали бы.
 */
class MediaResource extends Resource
{
    protected static ?string $model = Media::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Медиатека';

    protected static ?string $modelLabel = 'Файл';

    protected static ?string $pluralModelLabel = 'Файлы';

    public static function form(Schema $schema): Schema
    {
        return MediaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MediaTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMedia::route('/'),
            'edit' => EditMedia::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }
}
