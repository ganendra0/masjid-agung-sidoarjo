<?php

namespace App\Filament\Resources\StudyResource\Pages;

use App\Filament\Resources\StudyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudy extends EditRecord
{
    protected static string $resource = StudyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()->label('Lihat'),
            Actions\DeleteAction::make()->label('Hapus'),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Kajian berhasil diperbarui';
    }
}
