<?php

namespace Database\Seeders;

use App\Models\HeroBanner;
use App\Models\MosqueManager;
use Illuminate\Database\Seeder;

class ManagerAndBannerSeeder extends Seeder
{
    public function run(): void
    {
        if (! HeroBanner::exists()) {
            HeroBanner::insert([
                [
                    'title' => 'Selamat Datang di Masjid Agung Sidoarjo',
                    'subtitle' => 'Pusat Ibadah, Dakwah, Pendidikan, dan Pelayanan Umat.',
                    'image' => '', // kosong = placeholder; unggah foto asli lewat dashboard
                    'button_label' => 'Lihat Agenda Kajian',
                    'button_url' => '/agenda',
                    'sort_order' => 1,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Kajian dan Kegiatan Keislaman',
                    'subtitle' => '[Isi informasi banner melalui dashboard admin.]',
                    'image' => '',
                    'button_label' => 'Arsip Kajian',
                    'button_url' => '/kajian',
                    'sort_order' => 2,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        if (! MosqueManager::exists()) {
            foreach (['Ketua Takmir', 'Wakil Ketua', 'Sekretaris', 'Bendahara'] as $i => $position) {
                MosqueManager::create([
                    'name' => '[Nama Pengurus]',
                    'position' => $position,
                    'sort_order' => $i + 1,
                ]);
            }
        }
    }
}
