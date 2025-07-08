<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'plate' => strtoupper($this->faker->unique()->bothify('???-####')),
            'renavam' => $this->faker->unique()->numerify('###########'),
            'chassi' => $this->faker->unique()->bothify('#################'),
            'brand' => $this->faker->company,
            'model' => $this->faker->word,
            'manufacture_year' => $this->faker->year,
            'model_year' => $this->faker->year,
            'color' => $this->faker->safeColorName,
            'fuel' => $this->faker->randomElement(['Gasolina', 'Etanol', 'Diesel', 'Flex']),
            'vehicle_type' => $this->faker->word,
            'vehicle_specie' => $this->faker->word,
            'licensing_date' => $this->faker->date(),
            'licensing_status' => $this->faker->word,
            'owner_document' => $this->faker->numerify('###########'),
            'owner_name' => $this->faker->name,
            'lessee_document' => $this->faker->numerify('###########'),
            'lessee_name' => $this->faker->name,
            'antt_situation' => $this->faker->word,
            'status' => 'pending_onboarding',
        ];
    }
}
