<?php

namespace App\Filament\Resources\AgendaCategoryResource\Pages;

use App\Filament\Resources\AgendaCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAgendaCategory extends CreateRecord
{
    protected static string $resource = AgendaCategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Kategori agenda berhasil dibuat';
    }
}
