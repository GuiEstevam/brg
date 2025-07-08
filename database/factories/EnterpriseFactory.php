<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EnterpriseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cnpj' => $this->faker->unique()->numerify('##.###.###/####-##'),
            'name' => $this->faker->company,
            'state_registration' => $this->faker->optional()->numerify('#########'),
            'address' => $this->faker->streetAddress,
            'number' => $this->faker->buildingNumber,
            'uf' => $this->faker->stateAbbr,
            'complement' => $this->faker->optional()->secondaryAddress,
            'cep' => $this->faker->postcode,
            'district' => $this->faker->citySuffix,
            'city' => $this->faker->city,
            'responsible_name' => $this->faker->optional()->name,
            'responsible_email' => $this->faker->optional()->safeEmail,
            'responsible_phone' => $this->faker->optional()->phoneNumber,
            'status' => 'active',
        ];
    }
}
