<?php

namespace App\Filament\Widgets;

use App\Enums\PublishStatus;
use App\Models\Agenda;
use App\Models\News;
use App\Models\Study;
use Filament\Widgets\Widget;
use Illuminate\Support\Collection;

class RecentActivityWidget extends Widget
{
    protected string $view = 'filament.widgets.recent-activity-widget';

    protected int|string|array $columnSpan = 'full';

    /** @return Collection<int, array{type: string, title: string, status: string, created_at: mixed}> */
    protected function getActivities(): Collection
    {
        return collect()
            ->concat(News::query()->latest()->limit(10)->get()->map(fn (News $item) => ['type' => 'Berita', 'title' => $item->title, 'status' => $item->status instanceof PublishStatus ? $item->status->value : (string) $item->status, 'created_at' => $item->created_at]))
            ->concat(Agenda::query()->latest()->limit(10)->get()->map(fn (Agenda $item) => ['type' => 'Agenda', 'title' => $item->title, 'status' => $item->status instanceof PublishStatus ? $item->status->value : (string) $item->status, 'created_at' => $item->created_at]))
            ->concat(Study::query()->latest()->limit(10)->get()->map(fn (Study $item) => ['type' => 'Kajian', 'title' => $item->title, 'status' => $item->status instanceof PublishStatus ? $item->status->value : (string) $item->status, 'created_at' => $item->created_at]))
            ->sortByDesc('created_at')
            ->take(10)
            ->values();
    }

    protected function getViewData(): array
    {
        return ['activities' => $this->getActivities()];
    }
}
