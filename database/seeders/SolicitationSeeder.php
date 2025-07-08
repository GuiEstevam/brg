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
        // Cria 5 solicitações para cada empresa, vinculando usuários, motoristas e veículos aleatórios
        Enterprise::all()->each(function ($enterprise) {
            Solicitation::factory()->count(5)->create([
                'enterprise_id' => $enterprise->id,
                'user_id' => User::inRandomOrder()->first()?->id,
                'branch_id' => $enterprise->branches()->inRandomOrder()->first()?->id,
                'driver_id' => Driver::inRandomOrder()->first()?->id,
                'vehicle_id' => Vehicle::inRandomOrder()->first()?->id,
            ]);
        });
    }
}
