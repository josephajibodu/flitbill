<?php

namespace Database\Factories;

use App\Models\Cable;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CableFactory extends Factory
{
    protected $model = Cable::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'reference' => $this->faker->word(),
            'amount' => $this->faker->word(),
            'tv_identifier' => $this->faker->word(),
            'plan' => $this->faker->word(),
            'provider' => $this->faker->word(),
            'service' => $this->faker->word(),
            'status' => $this->faker->word(),
            'metadata' => $this->faker->word(),

            'user_id' => User::factory(),
            'transaction_id' => Transaction::factory(),
        ];
    }
}
