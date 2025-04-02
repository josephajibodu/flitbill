<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'reference' => $this->faker->word(),
            'description' => $this->faker->text(),
            'type' => $this->faker->word(),
            'amount' => $this->faker->randomNumber(),
            'balance' => $this->faker->randomNumber(),
            'status' => $this->faker->word(),
            'commission' => $this->faker->word(),
            'metadata' => $this->faker->word(),

            'user_id' => User::factory(),
        ];
    }
}
