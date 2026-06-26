<?php

namespace Database\Factories;

use App\Enums\EscrowStatus;
use App\Models\EscrowTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class EscrowTransactionFactory extends Factory
{
    protected $model = EscrowTransaction::class;

    public function definition(): array
    {
        $amount = fake()->numberBetween(500000, 5000000);

        return [
            'amount_held' => $amount,
            'platform_fee' => $amount * 0.10,
            'kol_amount' => $amount * 0.90,
            'status' => EscrowStatus::HELD,
            'held_at' => now(),
        ];
    }
}
