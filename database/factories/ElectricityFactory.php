<?php

namespace Database\Factories;

use App\Models\Electricity;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ElectricityFactory extends Factory
{
    protected $model = Electricity::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'reference' => $this->faker->word(),
            'amount' => $this->faker->word(),
            'meter_number' => $this->faker->word(),
            'provider' => $this->faker->word(),
            'service' => $this->faker->word(),
            'meter_type' => $this->faker->word(),
            'token' => Str::random(10),
            'status' => $this->faker->word(),
            'metadata' => $this->faker->word(),

            'user_id' => User::factory(),
            'transaction_id' => Transaction::factory(),
        ];
    }
}
