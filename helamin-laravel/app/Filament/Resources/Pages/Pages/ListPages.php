<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Resources\Pages\PageResource;
use Filament\Resources\Pages\ListRecords;

class ListPages extends ListRecords
{
    protected static string $resource = PageResource::class;

    /**
     * Структура страниц задаётся PageSeeder: менеджеры не создают страницы.
     */
    protected function getHeaderActions(): array
    {
        return [];
    }
}
