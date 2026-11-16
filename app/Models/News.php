<?php

namespace App\Models;

use App\Enums\PublishStatus;
use App\Models\Concerns\HasImageUrl;
use App\Models\Concerns\HasPublishScope;
use App\Models\Concerns\HasSlug;
use App\Support\Text;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    use HasFactory, HasSlug, HasPublishScope, HasImageUrl;

    protected $table = 'news';

    protected $fillable = [
        'news_category_id', 'author_id', 'title', 'slug', 'excerpt', 'content',
        'thumbnail', 'status', 'published_at', 'meta_title', 'meta_description',
    ];

    protected function casts(): array
    {
        return ['published_at' => 'datetime'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(NewsCategory::class, 'news_category_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /** Tampil di publik: status published dan tanggal publikasi sudah tiba. */
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where($this->qualifyColumn('status'), PublishStatus::Published->value)
            ->where(fn ($q) => $q->whereNull($this->qualifyColumn('published_at'))
                ->orWhere($this->qualifyColumn('published_at'), '<=', now()));
    }

    public function scopeLatestPublished(Builder $query): Builder
    {
        return $query->published()->orderByDesc('published_at')->orderByDesc('id');
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        return $query->when(filled($term), fn ($q) => $q->where(function ($w) use ($term) {
            $like = '%'.str_replace(['%', '_'], ['\%', '\_'], $term).'%';
            $w->where('title', 'like', $like)->orWhere('excerpt', 'like', $like);
        }));
    }

    public function scopeInCategory(Builder $query, ?string $categorySlug): Builder
    {
        return $query->when(filled($categorySlug),
            fn ($q) => $q->whereHas('category', fn ($c) => $c->where('slug', $categorySlug)));
    }

    public function getThumbnailUrlAttribute(): string
    {
        return $this->imageUrl($this->thumbnail);
    }

    public function getSummaryAttribute(): string
    {
        return $this->excerpt ?: Text::plain($this->content, 160);
    }

    public function related(int $limit = 3)
    {
        return static::latestPublished()
            ->whereKeyNot($this->getKey())
            ->when($this->news_category_id, fn ($q) => $q->where('news_category_id', $this->news_category_id))
            ->limit($limit)
            ->get();
    }
}
