<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Enterprise;
use App\Models\Branch;
use App\Models\Solicitation;
use App\Models\Contract;
use App\Models\SolicitationPricing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_superadmin_has_global_access(): void
    {
        $superadmin = User::role('superadmin')->first();
        $this->actingAs($superadmin);

        // admin não tem acesso a enterprises.index pela rota? (tem pelo group superadmin|admin, mas sem contexto pode redirecionar)
        $this->followingRedirects()->get(route('enterprises.index'))->assertOk();
        $this->get(route('users.index'))->assertOk();
        $this->get(route('contracts.index'))->assertOk();
        $this->followingRedirects()->get(route('solicitation-pricings.index'))->assertOk();
        $this->get(route('drivers.index'))->assertOk();
        $this->get(route('vehicles.index'))->assertOk();
        $this->get(route('documents.index'))->assertOk();
        $this->get(route('solicitations.index'))->assertOk();
    }

    public function test_admin_scoped_access_and_pricing_view_only(): void
    {
        $admin = User::role('admin')->first();
        $this->actingAs($admin);
        $admin->forceFill(['email_verified_at' => now()])->save();

        // Define contexto para evitar redirect do middleware
        $enterpriseId = $admin->enterprises()->select('enterprises.id')->value('enterprises.id');
        $branchId = Branch::where('enterprise_id', $enterpriseId)->value('branches.id');
        session(['empresa_id' => $enterpriseId, 'filial_id' => $branchId]);

        // Empresas (index permitido)
        $this->followingRedirects()->get(route('enterprises.index'))->assertOk();
        $this->getJson(route('enterprises.create'))->assertStatus(403);

        // Solicitation Pricing: apenas visualização
        $this->followingRedirects()->get(route('solicitation-pricings.index'))->assertOk();
        $this->getJson(route('solicitation-pricings.create'))->assertStatus(403);

        // Contratos (permitido no escopo)
        $this->get(route('contracts.index'))->assertOk();
    }

    public function test_operator_can_manage_solicitations_only_in_context(): void
    {
        $operador = User::role('operador')->first();
        $this->actingAs($operador);
        $operador->forceFill(['email_verified_at' => now()])->save();

        // Simula contexto de sessão
        $enterpriseId = $operador->enterprises()->select('enterprises.id')->value('enterprises.id');
        $branchId = Branch::where('enterprise_id', $enterpriseId)->value('branches.id');
        session(['empresa_id' => $enterpriseId, 'filial_id' => $branchId]);

        $this->get(route('solicitations.index'))->assertOk();
        $this->get(route('solicitations.create'))->assertOk();
    }

    public function test_operator_cannot_delete_solicitation(): void
    {
        $operador = User::role('operador')->first();
        $this->actingAs($operador);

        $enterpriseId = $operador->enterprises()->select('enterprises.id')->value('enterprises.id');
        $branchId = Branch::where('enterprise_id', $enterpriseId)->value('branches.id');
        session(['empresa_id' => $enterpriseId, 'filial_id' => $branchId]);

        $s = Solicitation::factory()->create([
            'enterprise_id' => $enterpriseId,
            'branch_id' => $branchId,
            'user_id' => $operador->id,
            'status' => 'pending',
        ]);

        $this->deleteJson(route('solicitations.destroy', $s))
            ->assertStatus(403);
    }

    public function test_admin_cannot_create_pricing(): void
    {
        $admin = User::role('admin')->first();
        $this->actingAs($admin);
        $admin->forceFill(['email_verified_at' => now()])->save();
        $enterpriseId = $admin->enterprises()->select('enterprises.id')->value('enterprises.id');
        $branchId = Branch::where('enterprise_id', $enterpriseId)->value('branches.id');
        session(['empresa_id' => $enterpriseId, 'filial_id' => $branchId]);
        $this->getJson(route('solicitation-pricings.create'))
            ->assertStatus(403);
    }

    public function test_operator_cannot_access_users_index_but_can_view_own_profile_only(): void
    {
        $operador = User::role('operador')->first();
        $this->actingAs($operador);
        $operador->forceFill(['email_verified_at' => now()])->save();
        $enterpriseId = $operador->enterprises()->select('enterprises.id')->value('enterprises.id');
        $branchId = Branch::where('enterprise_id', $enterpriseId)->value('branches.id');
        session(['empresa_id' => $enterpriseId, 'filial_id' => $branchId]);
        // operador não pode ver index
        $this->getJson(route('users.index'))->assertStatus(403);
        // operador pode ver somente o próprio perfil
        $this->followingRedirects()->get(route('users.show', $operador))->assertOk();
        // operador não pode editar outro usuário
        $targetUser = User::where('id', '!=', $operador->id)->first();
        if ($targetUser) {
            $this->getJson(route('users.edit', $targetUser))->assertStatus(403);
        }
    }
}
