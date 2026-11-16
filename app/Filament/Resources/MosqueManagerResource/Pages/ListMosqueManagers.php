<?php

namespace App\Filament\Resources\MosqueManagerResource\Pages;

use App\Filament\Resources\MosqueManagerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMosqueManagers extends ListRecords
{
    protected static string $resource = MosqueManagerResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()->label('Tambah Pengurus')];
    }
}
