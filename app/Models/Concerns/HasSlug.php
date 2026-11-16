<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Membuat slug unik otomatis saat slug kosong.
 * Slug yang sudah ada tidak diubah agar URL (dan SEO) stabil.
 */
trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::saving(function (Model $model) {
            if (blank($model->slug)) {
                $model->slug = static::makeUniqueSlug($model, (string) $model->{$model->slugSource()});
            }
        });
    }

    public function slugSource(): string
    {
        return 'title';
    }

    protected static function makeUniqueSlug(Model $model, string $value): string
    {
        $base = Str::slug($value) ?: Str::random(8);
        $slug = $base;
        $i = 2;

        while (
            static::query()
                ->where('slug', $slug)
                ->when($model->exists, fn ($q) => $q->whereKeyNot($model->getKey()))
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
