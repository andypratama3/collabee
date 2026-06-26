<?php

namespace Database\Factories;

use App\Models\Agreement;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgreementFactory extends Factory
{
    protected $model = Agreement::class;

    public function definition(): array
    {
        return [
            'agreement_number' => 'AGR-'.fake()->unique()->randomNumber(5),
            'total_amount' => fake()->numberBetween(500000, 5000000),
            'platform_fee_percent' => 10.00,
            'status' => 'pending',
            'expires_at' => now()->addDays(7),
        ];
    }
}
