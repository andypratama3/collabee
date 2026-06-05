<?php

namespace Database\Factories;

use App\Models\Content;
use App\Enums\ContentStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContentFactory extends Factory
{
    protected $model = Content::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'caption' => fake()->paragraph(),
            'status' => ContentStatus::DRAFT,
        ];
    }
}
