<?php

namespace Database\Factories;

use App\Enums\HiringStatus;
use App\Models\Hiring;
use Illuminate\Database\Eloquent\Factories\Factory;

class HiringFactory extends Factory
{
    protected $model = Hiring::class;

    public function definition(): array
    {
        return [
            'initiated_by' => 'brand',
            'status' => HiringStatus::PENDING,
            'message' => fake()->sentence(),
            'proposed_budget' => fake()->numberBetween(500000, 5000000),
            'expires_at' => now()->addDays(7),
        ];
    }
}
