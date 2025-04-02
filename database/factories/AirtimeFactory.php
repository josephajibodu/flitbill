<?php

namespace Database\Factories;

use App\Models\Airtime;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AirtimeFactory extends Factory
{
    protected $model = Airtime::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'amount' => $this->faker->randomNumber(),
            'network' => $this->faker->word(),
            'phone_number' => $this->faker->phoneNumber(),
            'reference' => $this->faker->word(),
            'service' => $this->faker->word(),
            'metadata' => $this->faker->word(),

            'user_id' => User::factory(),
        ];
    }
}
