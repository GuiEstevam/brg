<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Auth\Access\HandlesAuthorization;

class VehiclePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'operador']);
    }

    public function view(User $user, Vehicle $vehicle): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'operador', 'veiculo']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'operador']);
    }

    public function update(User $user, Vehicle $vehicle): bool
    {
        if ($user->hasAnyRole(['superadmin', 'admin'])) return true;
        if ($user->hasRole('veiculo')) return $user->vehicle_id === $vehicle->id;
        return false;
    }

    public function delete(User $user, Vehicle $vehicle): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin']);
    }
}
