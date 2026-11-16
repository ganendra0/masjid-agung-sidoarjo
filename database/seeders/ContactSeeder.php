<?php

namespace Database\Seeders;

use App\Models\ContactSetting;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $contact = ContactSetting::current();

        if ($contact->address) {
            return;
        }

        $contact->update([
            'address' => '[Isi alamat resmi Masjid Agung Sidoarjo], Kabupaten Sidoarjo, Jawa Timur',
            'phone' => null,
            'whatsapp' => null,
            'email' => null,
            // Pencarian Google Maps; ganti dengan embed titik koordinat resmi lewat dashboard.
            'maps_embed_url' => 'https://www.google.com/maps?q=Masjid+Agung+Sidoarjo&output=embed',
            'instagram' => null,
            'facebook' => null,
            'youtube' => null,
            'tiktok' => null,
        ]);
    }
}
