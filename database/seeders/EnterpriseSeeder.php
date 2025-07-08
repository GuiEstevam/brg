<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enterprise;

class EnterpriseSeeder extends Seeder
{
    public function run()
    {
        Enterprise::factory()->count(10)->create();
    }
}
