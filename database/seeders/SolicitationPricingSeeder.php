<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SolicitationPricing;
use App\Models\Enterprise;

class SolicitationPricingSeeder extends Seeder
{
    public function run()
    {
        // Cria uma tabela de preços para cada empresa
        Enterprise::all()->each(function ($enterprise) {
            SolicitationPricing::factory()->create([
                'enterprise_id' => $enterprise->id,
            ]);
        });
    }
}
