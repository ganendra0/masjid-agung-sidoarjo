<?php

namespace Database\Factories;

use App\Models\Agenda;
use App\Models\AgendaCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Agenda> */
class AgendaFactory extends Factory
{
    protected $model = Agenda::class;

    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-1 month', '+2 months');

        return [
            'agenda_category_id' => AgendaCategory::query()->inRandomOrder()->value('id'),
            'title' => '[Contoh] Kajian '.fake()->words(3, true),
            'speaker' => '[Nama Ustadz]',
            'description' => '<p>'.fake()->paragraph(4).'</p>',
            'location' => 'Masjid Agung Sidoarjo',
            'starts_at' => $start,
            'ends_at' => (clone $start)->modify('+2 hours'),
            'status' => 'published',
        ];
    }

    public function upcoming(): static
    {
        $start = fake()->dateTimeBetween('+1 day', '+2 months');

        return $this->state(['starts_at' => $start, 'ends_at' => (clone $start)->modify('+2 hours')]);
    }

    public function past(): static
    {
        $start = fake()->dateTimeBetween('-2 months', '-1 day');

        return $this->state(['starts_at' => $start, 'ends_at' => (clone $start)->modify('+2 hours')]);
    }
}
