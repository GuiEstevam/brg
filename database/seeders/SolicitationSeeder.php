<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Solicitation;
use App\Models\Enterprise;
use App\Models\User;
use App\Models\Branch;
use App\Models\Driver;
use App\Models\Vehicle;

class SolicitationSeeder extends Seeder
{
    public function run()
    {
        // Cria solicitações para cada empresa
        Enterprise::all()->each(function ($enterprise) {
            // Criar solicitações de motorista
            for ($i = 0; $i < 3; $i++) {
                $driver = Driver::inRandomOrder()->first();
                Solicitation::create([
                    'enterprise_id' => $enterprise->id,
                    'user_id' => User::inRandomOrder()->first()->id,
                    'branch_id' => $enterprise->branches()->inRandomOrder()->first()?->id,
                    'entity_type' => 'driver',
                    'entity_value' => $driver->cpf,
                    'driver_id' => $driver->id,
                    'vehicle_id' => null,
                    'status' => 'pending',
                    'vincle_type' => fake()->randomElement(['autonomo', 'agregado', 'funcionario']),
                    'research_type' => fake()->randomElement(['basic', 'complete', 'express']),
                    'calculated_price' => fake()->randomFloat(2, 50, 150),
                    'auto_renewal' => fake()->boolean(20),
                    'notes' => fake()->optional(0.3)->sentence(),
                ]);
            }

            // Criar solicitações de veículo
            for ($i = 0; $i < 2; $i++) {
                $vehicle = Vehicle::inRandomOrder()->first();
                Solicitation::create([
                    'enterprise_id' => $enterprise->id,
                    'user_id' => User::inRandomOrder()->first()->id,
                    'branch_id' => $enterprise->branches()->inRandomOrder()->first()?->id,
                    'entity_type' => 'vehicle',
                    'entity_value' => $vehicle->plate,
                    'driver_id' => null,
                    'vehicle_id' => $vehicle->id,
                    'status' => 'pending',
                    'vincle_type' => fake()->randomElement(['autonomo', 'agregado', 'funcionario']),
                    'research_type' => fake()->randomElement(['basic', 'complete', 'express']),
                    'calculated_price' => fake()->randomFloat(2, 50, 150),
                    'auto_renewal' => fake()->boolean(20),
                    'notes' => fake()->optional(0.3)->sentence(),
                ]);
            }

            // Criar solicitações compostas
            for ($i = 0; $i < 2; $i++) {
                $driver = Driver::inRandomOrder()->first();
                $vehicle = Vehicle::inRandomOrder()->first();

                $solicitation = Solicitation::create([
                    'enterprise_id' => $enterprise->id,
                    'user_id' => User::inRandomOrder()->first()->id,
                    'branch_id' => $enterprise->branches()->inRandomOrder()->first()?->id,
                    'entity_type' => 'composed',
                    'entity_value' => "COMPOSED:{$driver->name}-{$vehicle->plate}",
                    'driver_id' => $driver->id,
                    'vehicle_id' => null, // Para composed, não usa vehicle_id direto
                    'status' => 'pending',
                    'vincle_type' => fake()->randomElement(['autonomo', 'agregado', 'funcionario']),
                    'research_type' => fake()->randomElement(['basic', 'complete', 'express']),
                    'calculated_price' => fake()->randomFloat(2, 100, 250),
                    'auto_renewal' => fake()->boolean(20),
                    'notes' => fake()->optional(0.3)->sentence(),
                ]);

                // Adicionar veículo ao relacionamento many-to-many
                $solicitation->vehicles()->attach($vehicle->id, [
                    'order' => 1,
                    'status' => 'active',
                ]);
            }
        });
    }
}
