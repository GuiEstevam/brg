<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DriverFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cpf' => $this->faker->unique()->numerify('###########'),
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'birth_date' => $this->faker->date(),
            'mother_name' => $this->faker->name('female'),
            'rg_number' => $this->faker->numerify('########'),
            'rg_uf' => $this->faker->stateAbbr,
            'status' => 'pending_onboarding',
        ];
    }
}
