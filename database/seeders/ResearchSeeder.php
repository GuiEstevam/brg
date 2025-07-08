<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Research;
use App\Models\Solicitation;
use App\Models\Driver;
use App\Models\Vehicle;

class ResearchSeeder extends Seeder
{
    public function run()
    {
        // Cria 1 pesquisa para cada solicitação
        Solicitation::all()->each(function ($solicitation) {
            Research::factory()->create([
                'solicitation_id' => $solicitation->id,
                'driver_id' => $solicitation->driver_id,
                'vehicle_id' => $solicitation->vehicle_id,
            ]);
        });
    }
}
