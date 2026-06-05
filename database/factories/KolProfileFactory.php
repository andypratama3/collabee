<?php

namespace Database\Factories;

use App\Models\KolProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class KolProfileFactory extends Factory
{
    protected $model = KolProfile::class;

    public function definition(): array
    {
        return [
            'display_name' => fake()->name(),
            'bio' => fake()->paragraph(),
            'category' => fake()->randomElement(['fashion', 'beauty', 'tech', 'food', 'travel', 'fitness']),
            'location' => fake()->city(),
            'gender' => fake()->randomElement(['male', 'female']),
            'total_followers' => fake()->numberBetween(1000, 100000),
            'avg_engagement_rate' => fake()->randomFloat(2, 0.5, 10),
            'total_campaigns_done' => 0,
            'total_earned' => 0,
            'wallet_balance' => 0,
            'pending_balance' => 0,
            'rating_avg' => 0,
            'rating_count' => 0,
            'is_open_for_work' => true,
            'min_budget' => fake()->numberBetween(100000, 1000000),
        ];
    }
}
