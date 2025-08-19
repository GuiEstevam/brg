<?php

namespace Tests\Feature;

use App\Models\SolicitationPricing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SolicitationPricingAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_admin_can_only_view_pricing_not_create(): void
    {
        $admin = User::role('admin')->first();
        $this->actingAs($admin);
        $admin->forceFill(['email_verified_at' => now()])->save();

        $enterpriseId = $admin->enterprises()->select('enterprises.id')->value('enterprises.id');
        session(['empresa_id' => $enterpriseId]);

        $this->followingRedirects()->get(route('solicitation-pricings.index'))->assertOk();
        $this->getJson(route('solicitation-pricings.create'))->assertStatus(403);
    }

    public function test_superadmin_can_crud_pricing(): void
    {
        $super = User::role('superadmin')->first();
        $this->actingAs($super);

        $this->followingRedirects()->get(route('solicitation-pricings.index'))->assertOk();
        $this->followingRedirects()->get(route('solicitation-pricings.create'))->assertOk();
    }
}
