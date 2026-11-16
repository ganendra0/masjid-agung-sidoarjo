<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgendaCategory extends Model
{
    use HasSlug;

    protected $fillable = ['name', 'slug', 'description'];

    public function slugSource(): string
    {
        return 'name';
    }

    public function agendas(): HasMany
    {
        return $this->hasMany(Agenda::class);
    }
}
