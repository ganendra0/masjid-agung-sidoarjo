<?php

namespace App\Models;

use App\Models\Concerns\HasImageUrl;
use App\Models\Concerns\HasPublishScope;
use App\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agenda extends Model
{
    use HasFactory, HasSlug, HasPublishScope, HasImageUrl;

    protected $fillable = [
        'agenda_category_id', 'title', 'slug', 'speaker', 'description',
        'poster', 'location', 'starts_at', 'ends_at', 'status',
    ];

    protected function casts(): array
    {
        return ['starts_at' => 'datetime', 'ends_at' => 'datetime'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(AgendaCategory::class, 'agenda_category_id');
    }

    /**
     * Mendatang = belum berakhir (memakai ends_at jika ada, jika tidak starts_at).
     * Status "terlaksana" dihitung dari waktu, tidak disimpan di database.
     */
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where(fn ($q) => $q
            ->where('ends_at', '>=', now())
            ->orWhere(fn ($w) => $w->whereNull('ends_at')->where('starts_at', '>=', now())))
            ->orderBy('starts_at');
    }

    public function scopePast(Builder $query): Builder
    {
        return $query->where(fn ($q) => $q
            ->where('ends_at', '<', now())
            ->orWhere(fn ($w) => $w->whereNull('ends_at')->where('starts_at', '<', now())))
            ->orderByDesc('starts_at');
    }

    public function scopeInCategory(Builder $query, ?string $categorySlug): Builder
    {
        return $query->when(filled($categorySlug),
            fn ($q) => $q->whereHas('category', fn ($c) => $c->where('slug', $categorySlug)));
    }

    public function scopeOnDate(Builder $query, ?string $date): Builder
    {
        return $query->when(filled($date), fn ($q) => $q->whereDate('starts_at', $date));
    }

    public function getIsPastAttribute(): bool
    {
        return ($this->ends_at ?? $this->starts_at)->isPast();
    }

    public function getPosterUrlAttribute(): string
    {
        return $this->imageUrl($this->poster);
    }

    public function getDateLabelAttribute(): string
    {
        return $this->starts_at->translatedFormat('l, d F Y');
    }

    public function getTimeLabelAttribute(): string
    {
        $label = $this->starts_at->format('H:i');

        if ($this->ends_at && $this->ends_at->isSameDay($this->starts_at)) {
            $label .= ' – '.$this->ends_at->format('H:i');
        }

        return $label.' WIB';
    }
}
