<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<News> */
class NewsFactory extends Factory
{
    protected $model = News::class;

    public function definition(): array
    {
        return [
            'news_category_id' => NewsCategory::query()->inRandomOrder()->value('id'),
            'title' => '[Contoh] '.fake()->sentence(6),
            'excerpt' => fake()->sentence(18),
            'content' => '<p>'.implode('</p><p>', fake()->paragraphs(4)).'</p>',
            'status' => 'published',
            'published_at' => fake()->dateTimeBetween('-2 months', 'now'),
        ];
    }

    public function draft(): static
    {
        return $this->state(['status' => 'draft', 'published_at' => null]);
    }
}
