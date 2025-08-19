<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Enterprise;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnterprisePolicyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_admin_can_edit_own_enterprise_only(): void
    {
        $admin = User::role('admin')->first();
        $this->actingAs($admin);
        $admin->forceFill(['email_verified_at' => now()])->save();

        $own = $admin->enterprises()->first();
        $other = Enterprise::whereKeyNot($own->id)->first();

        // Define contexto para evitar redirect do middleware
        session(['empresa_id' => $own->id]);

        // Alguns middlewares podem redirecionar se faltar contexto; garantimos 200/302->200 com follow
        $this->followingRedirects()->get(route('enterprises.edit', $own))->assertOk();
        // Para obter 403 puro (sem redirect customizado), pedimos JSON
        $this->getJson(route('enterprises.edit', $other))->assertStatus(403);
    }
}
