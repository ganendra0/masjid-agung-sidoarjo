<?php

namespace App\Filament\Widgets;

use App\Enums\PublishStatus;
use App\Models\Agenda;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Study;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Berita', News::count()),
            Stat::make('Total Agenda', Agenda::count()),
            Stat::make('Total Kajian', Study::count()),
            Stat::make('Total Galeri', Gallery::count()),
            Stat::make('Agenda Mendatang', Agenda::upcoming()->count()),
            Stat::make('Draft', News::where('status', PublishStatus::Draft->value)->count() + Agenda::where('status', PublishStatus::Draft->value)->count() + Study::where('status', PublishStatus::Draft->value)->count()),
            Stat::make('Published', News::where('status', PublishStatus::Published->value)->count() + Agenda::where('status', PublishStatus::Published->value)->count() + Study::where('status', PublishStatus::Published->value)->count()),
        ];
    }
}
