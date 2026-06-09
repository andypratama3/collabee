<?php

namespace Database\Factories;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignFactory extends Factory
{
    protected $model = Campaign::class;

    public function definition(): array
    {
        return [
            'brand_profile_id' => \App\Models\BrandProfile::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraphs(3, true),
            'brief' => fake()->paragraphs(2, true),
            'objectives' => [fake()->sentence(), fake()->sentence()],
            'platforms' => fake()->randomElements(['instagram', 'tiktok', 'youtube', 'twitter'], rand(1, 3)),
            'content_types' => fake()->randomElements(['photo', 'video', 'story', 'reels'], rand(1, 3)),
            'kol_category' => fake()->randomElement(['fashion', 'beauty', 'tech', 'food', 'travel', 'fitness']),
            'min_followers' => 1000,
            'max_followers' => 100000,
            'min_engagement' => 1.0,
            'budget_total' => fake()->numberBetween(5000000, 50000000),
            'budget_per_kol' => fake()->numberBetween(500000, 5000000),
            'kol_slots' => fake()->numberBetween(1, 10),
            'kol_filled' => 0,
            'start_date' => now()->addDays(7),
            'end_date' => now()->addDays(30),
            'deadline_apply' => now()->addDays(5),
            'status' => 'open',
            'is_featured' => false,
            'views_count' => 0,
            'applications_count' => 0,
        ];
    }
}
