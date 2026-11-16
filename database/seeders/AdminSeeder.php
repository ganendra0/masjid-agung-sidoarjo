<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Atur lewat .env: ADMIN_EMAIL, ADMIN_PASSWORD. WAJIB diganti sebelum production.
        $email = env('ADMIN_EMAIL', 'admin@masjidagungsidoarjo.test');

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Administrator',
                'password' => env('ADMIN_PASSWORD', 'GantiPasswordIni!2026'),
                'is_admin' => true,
            ]
        );
    }
}
