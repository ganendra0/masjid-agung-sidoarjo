<?php

namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Study;
use App\Models\User;
use Illuminate\Database\Seeder;

class SampleContentSeeder extends Seeder
{
    /** Data contoh bertanda "[Contoh]" agar mudah dikenali dan dihapus lewat dashboard. */
    public function run(): void
    {
        if (News::exists() || Agenda::exists() || Study::exists() || Gallery::exists()) {
            return;
        }

        $adminId = User::where('is_admin', true)->value('id');

        News::factory()->count(6)->create(['author_id' => $adminId]);
        News::factory()->draft()->count(1)->create(['author_id' => $adminId]);

        Agenda::factory()->upcoming()->count(4)->create();
        Agenda::factory()->past()->count(3)->create();

        Study::factory()->count(6)->create();
        Gallery::factory()->count(9)->create();
    }
}
