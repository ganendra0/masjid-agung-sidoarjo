<?php

namespace App\Filament\Resources\AgendaCategoryResource\Pages;

use App\Filament\Resources\AgendaCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAgendaCategory extends EditRecord
{
    protected static string $resource = AgendaCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->label('Hapus'),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Kategori agenda berhasil diperbarui';
    }
}
