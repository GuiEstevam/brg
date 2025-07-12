<?php

namespace Database\Factories;

use App\Models\Enterprise;
use Illuminate\Database\Eloquent\Factories\Factory;

class SolicitationPricingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'enterprise_id' => Enterprise::factory(),
            'description' => $this->faker->sentence,
            'individual_driver_price' => $this->faker->randomFloat(2, 50, 500),
            'individual_vehicle_price' => $this->faker->randomFloat(2, 50, 500),
            'unified_price' => $this->faker->randomFloat(2, 100, 1000),
            'unified_additional_vehicle_2' => $this->faker->randomFloat(2, 10, 100),
            'unified_additional_vehicle_3' => $this->faker->randomFloat(2, 10, 100),
            'unified_additional_vehicle_4' => $this->faker->randomFloat(2, 10, 100),
            'recurrence_autonomo' => $this->faker->boolean,
            'recurrence_agregado' => $this->faker->boolean,
            'recurrence_frota' => $this->faker->boolean,
            'validity_days' => $this->faker->numberBetween(30, 365),
            'validity_autonomo_days' => $this->faker->numberBetween(30, 365),
            'validity_agregado_days' => $this->faker->numberBetween(30, 365),
            'validity_funcionario_days' => $this->faker->numberBetween(30, 365),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
