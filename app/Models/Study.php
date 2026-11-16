<?php

namespace App\Models;

use App\Models\Concerns\HasPublishScope;
use App\Models\Concerns\HasSlug;
use App\Support\YouTube;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Study extends Model
{
    use HasFactory, HasPublishScope, HasSlug;

    protected $fillable = [
        'title', 'slug', 'speaker', 'theme', 'youtube_url', 'youtube_id',
        'description', 'content', 'studied_at', 'status',
    ];

    protected function casts(): array
    {
        return ['studied_at' => 'date'];
    }

    protected static function booted(): void
    {
        // Sinkronkan youtube_id setiap URL berubah.
        static::saving(function (Study $study) {
            if ($study->isDirty('youtube_url') || blank($study->youtube_id)) {
                $study->youtube_id = YouTube::extractId($study->youtube_url);
            }
        });
    }

    public function scopeLatestStudied(Builder $query): Builder
    {
        return $query->published()->orderByDesc('studied_at')->orderByDesc('id');
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        return $query->when(filled($term), fn ($q) => $q->where(function ($w) use ($term) {
            $like = '%'.str_replace(['%', '_'], ['\%', '\_'], $term).'%';
            $w->where('title', 'like', $like)
                ->orWhere('speaker', 'like', $like)
                ->orWhere('theme', 'like', $like);
        }));
    }

    public function scopeBySpeaker(Builder $query, ?string $speaker): Builder
    {
        return $query->when(filled($speaker), fn ($q) => $q->where('speaker', $speaker));
    }

    public function scopeByTheme(Builder $query, ?string $theme): Builder
    {
        return $query->when(filled($theme), fn ($q) => $q->where('theme', $theme));
    }

    public function getThumbnailUrlAttribute(): string
    {
        return YouTube::thumbnail($this->youtube_id) ?? asset('images/placeholder.svg');
    }

    public function getEmbedUrlAttribute(): ?string
    {
        return YouTube::embedUrl($this->youtube_id);
    }

    public function related(int $limit = 3)
    {
        return static::latestStudied()
            ->whereKeyNot($this->getKey())
            ->where(fn ($q) => $q->where('speaker', $this->speaker)
                ->when($this->theme, fn ($w) => $w->orWhere('theme', $this->theme)))
            ->limit($limit)
            ->get();
    }
}
