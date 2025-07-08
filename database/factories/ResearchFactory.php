<?php

namespace Database\Factories;

use App\Models\Solicitation;
use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResearchFactory extends Factory
{
    public function definition(): array
    {
        return [
            'solicitation_id' => Solicitation::factory(),
            'driver_id' => Driver::factory(),
            'vehicle_id' => Vehicle::factory(),
            'api_response' => [],
            'status_api' => $this->faker->optional()->randomElement(['Adequado ao risco', 'Inconclusivo']),
            'validity_date' => $this->faker->optional()->date(),
            'rejection_reasons' => [],
            'total_points' => $this->faker->optional()->numberBetween(0, 40),
        ];
    }
}
