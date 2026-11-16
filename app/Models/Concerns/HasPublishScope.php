<?php

namespace App\Models\Concerns;

use App\Enums\PublishStatus;
use Illuminate\Database\Eloquent\Builder;

trait HasPublishScope
{
    public function initializeHasPublishScope(): void
    {
        $this->mergeCasts(['status' => PublishStatus::class]);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where($this->qualifyColumn('status'), PublishStatus::Published->value);
    }
}
