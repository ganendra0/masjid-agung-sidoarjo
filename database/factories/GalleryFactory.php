<?php

namespace Database\Factories;

use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Gallery> */
class GalleryFactory extends Factory
{
    protected $model = Gallery::class;

    public function definition(): array
    {
        return [
            'gallery_category_id' => GalleryCategory::query()->inRandomOrder()->value('id'),
            'title' => '[Contoh] Dokumentasi '.fake()->words(2, true),
            'image' => '', // kosong = placeholder; unggah foto asli lewat dashboard
            'caption' => fake()->sentence(8),
            'taken_at' => fake()->dateTimeBetween('-6 months', 'now'),
            'status' => 'published',
        ];
    }
}
