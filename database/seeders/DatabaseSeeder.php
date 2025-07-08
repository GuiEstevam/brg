<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
public function run()
{
    $this->call([
        EnterpriseSeeder::class,
        BranchSeeder::class,
        ContractSeeder::class,
        DriverSeeder::class,
        VehicleSeeder::class,
        DocumentSeeder::class,
        DriverLicenseSeeder::class,
        SolicitationSeeder::class,
        ResearchSeeder::class,
        SolicitationPricingSeeder::class,
        // Adicione outros seeders conforme necessário
    ]);
}

}
