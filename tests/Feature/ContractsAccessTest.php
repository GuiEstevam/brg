<?php

namespace Tests\Feature;

use App\Models\Contract;
use App\Models\Enterprise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContractsAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_admin_can_list_and_create_contract_in_own_enterprise(): void
    {
        $admin = User::role('admin')->first();
        $this->actingAs($admin);
        $admin->forceFill(['email_verified_at' => now()])->save();

        $enterpriseId = $admin->enterprises()->select('enterprises.id')->value('enterprises.id');
        session(['empresa_id' => $enterpriseId]);

        $this->followingRedirects()->get(route('contracts.index'))->assertOk();
        $this->followingRedirects()->get(route('contracts.create'))->assertOk();

        $payload = [
            'enterprise_id' => $enterpriseId,
            'plan_name' => 'Plano X',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addMonth()->toDateString(),
            'status' => 'active',
            'max_users' => 10,
            'max_queries' => 1000,
            'total_queries_used' => 0,
        ];
        $this->post(route('contracts.store'), $payload)->assertRedirect();
    }

    public function test_admin_cannot_create_contract_for_other_enterprise(): void
    {
        $admin = User::role('admin')->first();
        $this->actingAs($admin);
        $admin->forceFill(['email_verified_at' => now()])->save();

        $ownEnterpriseId = $admin->enterprises()->select('enterprises.id')->value('enterprises.id');
        $otherEnterpriseId = Enterprise::where('id', '!=', $ownEnterpriseId)->value('id');
        session(['empresa_id' => $ownEnterpriseId]);

        $payload = [
            'enterprise_id' => $otherEnterpriseId,
            'plan_name' => 'Plano Y',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addMonth()->toDateString(),
            'status' => 'active',
        ];

        $this->postJson(route('contracts.store'), $payload)->assertStatus(403);
    }

    public function test_operator_cannot_access_contracts(): void
    {
        $operador = User::role('operador')->first();
        $this->actingAs($operador);
        $operador->forceFill(['email_verified_at' => now()])->save();

        $enterpriseId = $operador->enterprises()->select('enterprises.id')->value('enterprises.id');
        $branchId = \App\Models\Branch::where('enterprise_id', $enterpriseId)->value('branches.id');
        session(['empresa_id' => $enterpriseId, 'filial_id' => $branchId]);

        $this->getJson(route('contracts.index'))->assertStatus(403);
        $this->getJson(route('contracts.create'))->assertStatus(403);
    }
}
