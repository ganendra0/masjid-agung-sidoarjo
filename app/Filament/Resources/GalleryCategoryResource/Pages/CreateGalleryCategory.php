<?php

namespace App\Filament\Resources\GalleryCategoryResource\Pages;

use App\Filament\Resources\GalleryCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGalleryCategory extends CreateRecord
{
    protected static string $resource = GalleryCategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Kategori galeri berhasil dibuat';
    }
}
