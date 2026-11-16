<?php

namespace App\Models;

use App\Models\Concerns\HasImageUrl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class HeroBanner extends Model
{
    use HasImageUrl;

    protected $fillable = [
        'title', 'subtitle', 'image', 'button_label', 'button_url', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }

    public function getImageUrlAttribute(): string
    {
        return $this->imageUrl($this->image);
    }

    /** Hanya izinkan URL http(s) atau path relatif agar tidak ada skema berbahaya (javascript:). */
    public function getButtonLinkAttribute(): ?string
    {
        $url = trim((string) $this->button_url);

        if ($url === '') {
            return null;
        }

        if (preg_match('~^https?://~i', $url)) {
            return $url;
        }

        return str_starts_with($url, '/') && ! str_starts_with($url, '//') ? url($url) : null;
    }
}
