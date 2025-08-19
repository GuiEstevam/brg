<?php

namespace Database\Factories;

use App\Models\Enterprise;
use App\Models\User;
use App\Models\Branch;
use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class SolicitationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'enterprise_id' => Enterprise::factory(),
            'user_id' => User::factory(),
            'branch_id' => Branch::factory(),
            'driver_id' => Driver::factory(),
            'vehicle_id' => Vehicle::factory(),
            'entity_type' => $this->faker->randomElement(['driver', 'vehicle', 'composed']),
            'entity_value' => $this->faker->numerify('###########'),
            'status' => 'pending',
            'vincle_type' => $this->faker->randomElement(['autonomo', 'agregado', 'funcionario']),
            'research_type' => $this->faker->randomElement(['basic', 'complete', 'express']),
            'calculated_price' => $this->faker->randomFloat(2, 50, 200),
            'auto_renewal' => $this->faker->boolean(20),
            'original_solicitation_id' => null,
            'api_request_data' => [],
            'notes' => $this->faker->optional(0.3)->sentence(),
        ];
    }
}
