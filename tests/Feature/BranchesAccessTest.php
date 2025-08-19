<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Enterprise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BranchesAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_admin_can_access_branches_index_and_create_in_own_enterprise(): void
    {
        $admin = User::role('admin')->first();
        $this->actingAs($admin);
        $admin->forceFill(['email_verified_at' => now()])->save();

        $enterpriseId = $admin->enterprises()->select('enterprises.id')->value('enterprises.id');
        $branchId = Branch::where('enterprise_id', $enterpriseId)->value('branches.id');
        session(['empresa_id' => $enterpriseId, 'filial_id' => $branchId]);

        $this->followingRedirects()->get(route('branches.index'))->assertOk();
        $this->followingRedirects()->get(route('branches.create'))->assertOk();

        // store for own enterprise ok
        $payload = [
            'enterprise_id' => $enterpriseId,
            'name' => 'Filial Nova',
            'cnpj' => '12.345.678/0001-90',
            'address' => 'Rua X',
            'number' => '123',
            'uf' => 'SP',
            'cep' => '01001-000',
            'district' => 'Centro',
            'city' => 'São Paulo',
            'phone' => '1133334444',
            'email' => 'filial@example.com',
            'status' => 'active',
        ];
        $this->post(route('branches.store'), $payload)->assertRedirect();
    }

    public function test_admin_cannot_create_branch_for_other_enterprise(): void
    {
        $admin = User::role('admin')->first();
        $this->actingAs($admin);
        $admin->forceFill(['email_verified_at' => now()])->save();

        $ownEnterpriseId = $admin->enterprises()->select('enterprises.id')->value('enterprises.id');
        $otherEnterpriseId = Enterprise::where('id', '!=', $ownEnterpriseId)->value('id');
        $branchId = Branch::where('enterprise_id', $ownEnterpriseId)->value('branches.id');
        session(['empresa_id' => $ownEnterpriseId, 'filial_id' => $branchId]);

        $payload = [
            'enterprise_id' => $otherEnterpriseId,
            'name' => 'Filial Inválida',
            'cnpj' => '23.456.789/0001-01',
            'address' => 'Rua Y',
            'number' => '10',
            'uf' => 'RJ',
            'cep' => '20010-000',
            'district' => 'Centro',
            'city' => 'Rio de Janeiro',
            'phone' => '2133334444',
            'email' => 'filial2@example.com',
            'status' => 'active',
        ];

        $this->postJson(route('branches.store'), $payload)->assertStatus(403);
    }

    public function test_operator_cannot_access_branches_routes(): void
    {
        $operador = User::role('operador')->first();
        $this->actingAs($operador);
        $operador->forceFill(['email_verified_at' => now()])->save();

        $enterpriseId = $operador->enterprises()->select('enterprises.id')->value('enterprises.id');
        $branchId = Branch::where('enterprise_id', $enterpriseId)->value('branches.id');
        session(['empresa_id' => $enterpriseId, 'filial_id' => $branchId]);

        $this->getJson(route('branches.index'))->assertStatus(403);
        $this->getJson(route('branches.create'))->assertStatus(403);
    }
}
