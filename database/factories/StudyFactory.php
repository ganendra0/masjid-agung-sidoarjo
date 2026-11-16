<?php

namespace Database\Factories;

use App\Models\Study;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Study> */
class StudyFactory extends Factory
{
    protected $model = Study::class;

    public function definition(): array
    {
        return [
            'title' => '[Contoh] Kajian '.fake()->words(3, true),
            'speaker' => fake()->randomElement(['[Ustadz A]', '[Ustadz B]', '[Ustadz C]']),
            'theme' => fake()->randomElement(['Akidah', 'Fikih', 'Akhlak', 'Tafsir']),
            // ID placeholder 11 karakter: ganti dengan URL YouTube asli lewat dashboard admin.
            'youtube_url' => 'https://www.youtube.com/watch?v=XXXXXXXXXXX',
            'description' => '<p>'.fake()->paragraph(3).'</p>',
            'studied_at' => fake()->dateTimeBetween('-6 months', 'now'),
            'status' => 'published',
        ];
    }
}
