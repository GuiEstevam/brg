<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Driver;

class DocumentSeeder extends Seeder
{
    public function run()
    {
        // Cria 2 documentos para cada motorista
        Driver::all()->each(function ($driver) {
            Document::factory()->count(1)->create([
                'owner_id' => $driver->id,
                'owner_type' => 'App\Models\Driver',
            ]);
        });
    }
}
