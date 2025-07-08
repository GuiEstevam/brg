<?php

namespace Database\Factories;

use App\Models\Enterprise;
use Illuminate\Database\Eloquent\Factories\Factory;

class BranchFactory extends Factory
{
    public function definition(): array
    {
        return [
            'enterprise_id' => Enterprise::factory(),
            'name' => $this->faker->company . ' Branch',
            'cnpj' => $this->faker->optional()->unique()->numerify('##.###.###/####-##'),
            'address' => $this->faker->streetAddress,
            'number' => $this->faker->buildingNumber,
            'uf' => $this->faker->stateAbbr,
            'cep' => $this->faker->postcode,
            'district' => $this->faker->citySuffix,
            'city' => $this->faker->city,
            'phone' => $this->faker->optional()->phoneNumber,
            'email' => $this->faker->optional()->safeEmail,
            'status' => 'active',
        ];
    }
}
