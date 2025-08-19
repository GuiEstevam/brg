<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Driver;
use App\Models\Enterprise;
use App\Models\Solicitation;
use App\Models\SolicitationPricing;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // Empresas fixas
        $enterpriseA = Enterprise::factory()->create(['name' => 'Empresa A']);
        $enterpriseB = Enterprise::factory()->create(['name' => 'Empresa B']);

        // Filiais
        $branchA1 = Branch::factory()->create(['enterprise_id' => $enterpriseA->id, 'name' => 'Filial A1']);
        $branchB1 = Branch::factory()->create(['enterprise_id' => $enterpriseB->id, 'name' => 'Filial B1']);

        // Usuários
        $super = User::factory()->create(['email' => 'super@example.com']);
        $super->assignRole('superadmin');

        $adminA = User::factory()->create(['email' => 'admina@example.com']);
        $adminA->assignRole('admin');
        $adminA->enterprises()->sync([$enterpriseA->id]);

        $adminB = User::factory()->create(['email' => 'adminb@example.com']);
        $adminB->assignRole('admin');
        $adminB->enterprises()->sync([$enterpriseB->id]);

        $opA = User::factory()->create(['email' => 'opa@example.com']);
        $opA->assignRole('operador');
        $opA->enterprises()->sync([$enterpriseA->id]);
        $opA->branches()->sync([$branchA1->id]);

        // Tabela de preços por empresa
        SolicitationPricing::factory()->create(['enterprise_id' => $enterpriseA->id, 'status' => 'active']);
        SolicitationPricing::factory()->create(['enterprise_id' => $enterpriseB->id, 'status' => 'inactive']);

        // Solicitações de exemplo
        $driver = Driver::factory()->create();
        $sol = Solicitation::factory()->create([
            'enterprise_id' => $enterpriseA->id,
            'branch_id' => $branchA1->id,
            'user_id' => $opA->id,
            'driver_id' => $driver->id,
            'status' => 'pending',
        ]);
    }
}
