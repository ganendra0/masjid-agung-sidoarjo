<?php

namespace App\Filament\Resources\NewsResource\Pages;

use App\Enums\PublishStatus;
use App\Filament\Resources\NewsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNews extends EditRecord
{
    protected static string $resource = NewsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()->label('Lihat'),
            Actions\DeleteAction::make()->label('Hapus'),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Berita berhasil diperbarui';
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Jika status diubah ke published dan published_at belum diisi, set ke sekarang.
        if (($data['status'] ?? null) === PublishStatus::Published->value && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $data;
    }
}
