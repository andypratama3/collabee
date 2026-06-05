<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'amount' => fake()->numberBetween(500000, 5000000),
            'platform_fee' => fake()->numberBetween(50000, 500000),
            'total_amount' => fn (array $attrs) => $attrs['amount'] + $attrs['platform_fee'],
            'gateway' => 'xendit',
            'invoice_number' => 'INV-2026-' . fake()->unique()->randomNumber(5),
            'status' => 'pending',
        ];
    }
}
