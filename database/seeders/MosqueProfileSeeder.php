<?php

namespace Database\Seeders;

use App\Models\MosqueProfile;
use Illuminate\Database\Seeder;

class MosqueProfileSeeder extends Seeder
{
    public function run(): void
    {
        // Semua teks di bawah adalah PLACEHOLDER. Ganti lewat dashboard admin (Profil Masjid).
        $profile = MosqueProfile::current();

        if ($profile->description) {
            return; // jangan timpa data yang sudah diedit admin
        }

        $profile->update([
            'name' => 'Masjid Agung Sidoarjo',
            'tagline' => 'Pusat Ibadah, Dakwah, Pendidikan, dan Pelayanan Umat.',
            'description' => '<p>[Isi deskripsi singkat Masjid Agung Sidoarjo melalui dashboard admin.]</p>',
            'history' => '<p>[Isi sejarah berdirinya masjid melalui dashboard admin.]</p>',
            'vision' => '[Isi visi masjid.]',
            'mission' => '<ul><li>[Misi pertama]</li><li>[Misi kedua]</li><li>[Misi ketiga]</li></ul>',
            'facilities' => [
                ['name' => 'Ruang Utama Sholat', 'description' => '[Isi deskripsi fasilitas]'],
                ['name' => 'Tempat Wudhu', 'description' => '[Isi deskripsi fasilitas]'],
                ['name' => 'Area Parkir', 'description' => '[Isi deskripsi fasilitas]'],
                ['name' => 'Perpustakaan', 'description' => '[Isi deskripsi fasilitas]'],
            ],
            'established_year' => null,
        ]);
    }
}
