<?php

namespace App\Filament\Resources\StudyResource\Pages;

use App\Filament\Resources\StudyResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewStudy extends ViewRecord
{
    protected static string $resource = StudyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()->label('Edit'),
            Actions\DeleteAction::make()->label('Hapus'),
        ];
    }
}
