<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            CategorySeeder::class,
            MosqueProfileSeeder::class,
            ContactSeeder::class,
            ManagerAndBannerSeeder::class,
        ]);

        // Konten contoh hanya untuk lingkungan lokal/testing.
        // Jalankan manual di tempat lain: php artisan db:seed --class=SampleContentSeeder
        if (app()->environment(['local', 'testing'])) {
            $this->call(SampleContentSeeder::class);
        }
    }
}
