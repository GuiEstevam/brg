<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DriverLicense;
use App\Models\Driver;

class DriverLicenseSeeder extends Seeder
{
    public function run()
    {
        // Cria uma CNH para cada motorista
        Driver::all()->each(function ($driver) {
            DriverLicense::factory()->create([
                'driver_id' => $driver->id,
            ]);
        });
    }
}
