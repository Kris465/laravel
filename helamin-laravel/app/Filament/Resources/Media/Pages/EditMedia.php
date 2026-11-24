<?php

namespace App\Filament\Resources\Media\Pages;

use App\Filament\Resources\Media\MediaResource;
use Filament\Resources\Pages\EditRecord;

class EditMedia extends EditRecord
{
    protected static string $resource = MediaResource::class;

    /** Удаление файлов из медиатеки запрещено: на них ссылается контент. */
    protected function getHeaderActions(): array
    {
        return [];
    }
}
