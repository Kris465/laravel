<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Resources\Pages\PageResource;
use App\Models\Media;
use App\Models\Page;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    /**
     * Сразу после сохранения регистрируем загруженные файлы в медиатеке —
     * у них появляются стабильные ID и кнопки «Вставить в текст».
     */
    protected function afterSave(): void
    {
        $record = $this->getRecord();

        if ($record instanceof Page) {
            Media::syncForPage($record);
        }
    }

    /**
     * Удаление страниц запрещено: структура сайта задаётся кодом.
     */
    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
        ];
    }
}
