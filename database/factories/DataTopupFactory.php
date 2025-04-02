<?php

namespace Database\Factories;

use App\Models\DataTopup;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DataTopupFactory extends Factory
{
    protected $model = DataTopup::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'reference' => $this->faker->word(),
            'amount' => $this->faker->randomNumber(),
            'network' => $this->faker->word(),
            'phone_number' => $this->faker->phoneNumber(),
            'plan' => $this->faker->word(),
            'service' => $this->faker->word(),
            'metadata' => $this->faker->word(),
            'status' => $this->faker->word(),

            'user_id' => User::factory(),
            'transaction_id' => Transaction::factory(),
        ];
    }
}
