<?php

namespace App\Filament\Resources\MosqueManagerResource\Pages;

use App\Filament\Resources\MosqueManagerResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMosqueManager extends EditRecord
{
    protected static string $resource = MosqueManagerResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()->label('Hapus')];
    }
}
