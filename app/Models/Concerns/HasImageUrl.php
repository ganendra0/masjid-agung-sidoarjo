<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Storage;

trait HasImageUrl
{
    protected function imageUrl(?string $path, string $placeholder = 'images/placeholder.svg'): string
    {
        return $path ? Storage::disk('public')->url($path) : asset($placeholder);
    }
}
