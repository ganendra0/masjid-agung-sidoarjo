<?php

namespace App\Models;

use App\Models\Concerns\HasImageUrl;
use Illuminate\Database\Eloquent\Model;

class MosqueProfile extends Model
{
    use HasImageUrl;

    protected $fillable = [
        'name', 'tagline', 'description', 'history', 'vision', 'mission',
        'facilities', 'photo', 'established_year',
    ];

    protected function casts(): array
    {
        return ['facilities' => 'array'];
    }

    /** Profil bersifat singleton: selalu ambil baris pertama, buat jika belum ada. */
    public static function current(): self
    {
        return static::query()->firstOrCreate([], ['name' => 'Masjid Agung Sidoarjo']);
    }

    public function getPhotoUrlAttribute(): string
    {
        return $this->imageUrl($this->photo);
    }
}
