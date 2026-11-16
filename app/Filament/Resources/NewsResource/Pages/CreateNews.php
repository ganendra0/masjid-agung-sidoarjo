<?php

namespace App\Filament\Resources\NewsResource\Pages;

use App\Enums\PublishStatus;
use App\Filament\Resources\NewsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateNews extends CreateRecord
{
    protected static string $resource = NewsResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Berita berhasil dibuat';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Jika status published tapi published_at kosong, isi dengan waktu sekarang.
        if (($data['status'] ?? null) === PublishStatus::Published->value && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $data;
    }
}
