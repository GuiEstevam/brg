<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DriversVehiclesDocumentsAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_admin_can_access_and_create_drivers_vehicles_documents(): void
    {
        $admin = \App\Models\User::role('admin')->first();
        $this->actingAs($admin);
        $admin->forceFill(['email_verified_at' => now()])->save();
        $enterpriseId = $admin->enterprises()->select('enterprises.id')->value('enterprises.id');
        $branchId = \App\Models\Branch::where('enterprise_id', $enterpriseId)->value('branches.id');
        session(['empresa_id' => $enterpriseId, 'filial_id' => $branchId]);

        $this->followingRedirects()->get(route('drivers.index'))->assertOk();
        $this->followingRedirects()->get(route('drivers.create'))->assertOk();

        $this->followingRedirects()->get(route('vehicles.index'))->assertOk();
        $this->followingRedirects()->get(route('vehicles.create'))->assertOk();

        $this->followingRedirects()->get(route('documents.index'))->assertOk();
        $this->followingRedirects()->get(route('documents.create'))->assertOk();

        $this->followingRedirects()->get(route('driver-licenses.index'))->assertOk();
        $this->followingRedirects()->get(route('driver-licenses.create'))->assertOk();
    }

    public function test_operator_can_access_lists_and_create_forms_per_policies(): void
    {
        $operador = \App\Models\User::role('operador')->first();
        $this->actingAs($operador);
        $operador->forceFill(['email_verified_at' => now()])->save();
        $enterpriseId = $operador->enterprises()->select('enterprises.id')->value('enterprises.id');
        $branchId = \App\Models\Branch::where('enterprise_id', $enterpriseId)->value('branches.id');
        session(['empresa_id' => $enterpriseId, 'filial_id' => $branchId]);

        $this->followingRedirects()->get(route('drivers.index'))->assertOk();
        $this->followingRedirects()->get(route('vehicles.index'))->assertOk();
        $this->followingRedirects()->get(route('documents.index'))->assertOk();
        $this->followingRedirects()->get(route('driver-licenses.index'))->assertOk();

        $this->followingRedirects()->get(route('drivers.create'))->assertOk();
        $this->followingRedirects()->get(route('vehicles.create'))->assertOk();
        $this->followingRedirects()->get(route('documents.create'))->assertOk();
        $this->followingRedirects()->get(route('driver-licenses.create'))->assertOk();
    }

    public function test_operator_cannot_update_or_delete_others_records(): void
    {
        $operador = \App\Models\User::role('operador')->first();
        $this->actingAs($operador);
        $operador->forceFill(['email_verified_at' => now()])->save();
        $enterpriseId = $operador->enterprises()->select('enterprises.id')->value('enterprises.id');
        $branchId = \App\Models\Branch::where('enterprise_id', $enterpriseId)->value('branches.id');
        session(['empresa_id' => $enterpriseId, 'filial_id' => $branchId]);

        // Cria registros "de terceiros"
        $otherUser = \App\Models\User::role('admin')->first();
        $driver = \App\Models\Driver::factory()->create();
        $vehicle = \App\Models\Vehicle::factory()->create();
        $license = \App\Models\DriverLicense::factory()->create(['driver_id' => $driver->id]);
        $document = \App\Models\Document::factory()->create([
            'owner_id' => $driver->id,
            'owner_type' => \App\Models\Driver::class,
        ]);

        // update/edit devem ser 403 para operador quando alvo não é dele
        $this->getJson(route('drivers.edit', $driver))->assertStatus(403);
        $this->getJson(route('vehicles.edit', $vehicle))->assertStatus(403);
        $this->getJson(route('documents.edit', $document))->assertStatus(403);
        $this->getJson(route('driver-licenses.edit', $license))->assertStatus(403);

        // delete
        $this->deleteJson(route('drivers.destroy', $driver))->assertStatus(403);
        $this->deleteJson(route('vehicles.destroy', $vehicle))->assertStatus(403);
        $this->deleteJson(route('documents.destroy', $document))->assertStatus(403);
        $this->deleteJson(route('driver-licenses.destroy', $license))->assertStatus(403);
    }
}
