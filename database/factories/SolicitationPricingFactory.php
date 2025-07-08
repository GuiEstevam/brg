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
            'individual_driver_price' => $this->faker->randomFloat(2, 10, 100),
            'individual_vehicle_price' => $this->faker->randomFloat(2, 10, 100),
            'unified_price' => $this->faker->randomFloat(2, 10, 200),
            'individual_driver_recurring' => $this->faker->boolean,
            'individual_vehicle_recurring' => $this->faker->boolean,
            'unified_recurring' => $this->faker->boolean,
            'validity_days' => $this->faker->numberBetween(1, 365),
            'price_expressa_driver' => $this->faker->randomFloat(2, 10, 100),
            'price_normal_driver' => $this->faker->randomFloat(2, 10, 100),
            'price_plus_driver' => $this->faker->randomFloat(2, 10, 100),
            'price_expressa_vehicle' => $this->faker->randomFloat(2, 10, 100),
            'price_normal_vehicle' => $this->faker->randomFloat(2, 10, 100),
            'price_plus_vehicle' => $this->faker->randomFloat(2, 10, 100),
            'price_expressa_unified' => $this->faker->randomFloat(2, 10, 200),
            'price_normal_unified' => $this->faker->randomFloat(2, 10, 200),
            'price_plus_unified' => $this->faker->randomFloat(2, 10, 200),
            'unified_additional_per_vehicle_expressa' => $this->faker->randomFloat(2, 1, 50),
            'unified_additional_per_vehicle_normal' => $this->faker->randomFloat(2, 1, 50),
            'unified_additional_per_vehicle_plus' => $this->faker->randomFloat(2, 1, 50),
            'validity_autonomo_days' => $this->faker->numberBetween(1, 365),
            'validity_agregado_days' => $this->faker->numberBetween(1, 365),
            'validity_funcionario_days' => $this->faker->numberBetween(1, 365),
            'description' => $this->faker->optional()->sentence,
            'status' => 'active',
        ];
    }
}
