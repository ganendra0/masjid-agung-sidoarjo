<?php

namespace App\Filament\Resources\HeroBannerResource\Pages;

use App\Filament\Resources\HeroBannerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHeroBanner extends EditRecord
{
    protected static string $resource = HeroBannerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->label('Hapus'),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Banner berhasil diperbarui';
    }
}
