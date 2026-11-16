<?php

namespace App\Models;

use App\Models\Concerns\HasImageUrl;
use App\Models\Concerns\HasPublishScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gallery extends Model
{
    use HasFactory, HasPublishScope, HasImageUrl;

    protected $fillable = ['gallery_category_id', 'title', 'image', 'caption', 'taken_at', 'status'];

    protected function casts(): array
    {
        return ['taken_at' => 'date'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(GalleryCategory::class, 'gallery_category_id');
    }

    public function scopeLatestTaken(Builder $query): Builder
    {
        return $query->published()->orderByDesc('taken_at')->orderByDesc('id');
    }

    public function scopeInCategory(Builder $query, ?string $categorySlug): Builder
    {
        return $query->when(filled($categorySlug),
            fn ($q) => $q->whereHas('category', fn ($c) => $c->where('slug', $categorySlug)));
    }

    public function getImageUrlAttribute(): string
    {
        return $this->imageUrl($this->image);
    }
}
