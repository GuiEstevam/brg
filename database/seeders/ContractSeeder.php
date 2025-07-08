<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contract;
use App\Models\Enterprise;

class ContractSeeder extends Seeder
{
    public function run()
    {
        // Cria 1 contrato para cada empresa
        Enterprise::all()->each(function ($enterprise) {
            Contract::factory()->create([
                'enterprise_id' => $enterprise->id,
            ]);
        });
    }
}
