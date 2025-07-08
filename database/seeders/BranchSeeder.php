<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;
use App\Models\Enterprise;

class BranchSeeder extends Seeder
{
    public function run()
    {
        // Cria 2 filiais para cada empresa existente
        Enterprise::all()->each(function ($enterprise) {
            Branch::factory()->count(2)->create([
                'enterprise_id' => $enterprise->id,
            ]);
        });
    }
}
