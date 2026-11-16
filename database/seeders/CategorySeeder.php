<?php

namespace Database\Seeders;

use App\Models\AgendaCategory;
use App\Models\GalleryCategory;
use App\Models\NewsCategory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $sets = [
            NewsCategory::class => ['Pengumuman', 'Kegiatan', 'Sosial', 'Artikel Islami'],
            AgendaCategory::class => ['Kajian Rutin', 'Kajian Akbar', 'Pendidikan', 'Sosial'],
            GalleryCategory::class => ['Kegiatan Ibadah', 'Kajian', 'Sosial', 'Fasilitas'],
        ];

        foreach ($sets as $model => $names) {
            foreach ($names as $name) {
                $model::firstOrCreate(['name' => $name]);
            }
        }
    }
}
