<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'plate' => strtoupper($this->faker->unique()->bothify('???-####')),
            'renavam' => $this->faker->unique()->optional()->numerify('###########'),
            'chassi' => $this->faker->unique()->optional()->bothify('#################'),
            'brand' => $this->faker->optional()->company,
            'model' => $this->faker->optional()->word,
            'manufacture_year' => $this->faker->optional()->year,
            'model_year' => $this->faker->optional()->year,
            'color' => $this->faker->optional()->safeColorName,
            'fuel' => $this->faker->optional()->randomElement(['Gasolina', 'Etanol', 'Diesel', 'Flex']),
            'vehicle_type' => $this->faker->optional()->word,
            'vehicle_specie' => $this->faker->optional()->word,
            'licensing_date' => $this->faker->optional()->date(),
            'licensing_status' => $this->faker->optional()->word,
            'owner_document' => $this->faker->optional()->numerify('###########'),
            'owner_name' => $this->faker->optional()->name,
            'lessee_document' => $this->faker->optional()->numerify('###########'),
            'lessee_name' => $this->faker->optional()->name,
            'antt_situation' => $this->faker->optional()->word,
            'status' => 'pending_onboarding',
        ];
    }
}
