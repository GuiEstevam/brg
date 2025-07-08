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
            'type' => $this->faker->randomElement(['driver', 'vehicle', 'composed']),
            'subtype' => $this->faker->randomElement(['person_process', 'cnh', 'vehicle_data', 'integrated', 'ocr', 'analysis']),
            'value' => $this->faker->numerify('###########'),
            'status' => 'pending',
            'vincle_type' => $this->faker->randomElement(['Autonomo', 'Agregado', 'Funcionario']),
            'research_type' => $this->faker->randomElement(['Expressa', 'Normal', 'Pesquisa_Mais']),
            'original_solicitation_id' => null,
            'api_request_data' => [],
        ];
    }
}
