<?php

namespace Database\Factories;

use App\Models\KolBankAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class KolBankAccountFactory extends Factory
{
    protected $model = KolBankAccount::class;

    public function definition(): array
    {
        return [
            'bank_name' => fake()->randomElement(['BCA', 'Mandiri', 'BNI', 'BRI']),
            'account_name' => fake()->name(),
            'account_number' => fake()->bankAccountNumber(),
        ];
    }
}
