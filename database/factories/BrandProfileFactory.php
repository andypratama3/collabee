<?php

namespace Database\Factories;

use App\Models\BrandProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandProfileFactory extends Factory
{
    protected $model = BrandProfile::class;

    public function definition(): array
    {
        return [
            'brand_name' => fake()->company(),
            'description' => fake()->paragraph(),
            'industry' => fake()->randomElement(['fashion', 'beauty', 'tech', 'food', 'travel', 'fitness']),
            'website' => fake()->url(),
            'location' => fake()->city(),
            'total_campaigns' => 0,
            'total_spent' => 0,
            'rating_avg' => 0,
            'rating_count' => 0,
        ];
    }
}
