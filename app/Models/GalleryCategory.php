<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GalleryCategory extends Model
{
    use HasSlug;

    protected $fillable = ['name', 'slug', 'description'];

    public function slugSource(): string
    {
        return 'name';
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }
}
