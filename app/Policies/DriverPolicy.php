<?php

namespace App\Policies;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DriverPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'operador']);
    }

    public function view(User $user, Driver $driver): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'operador', 'motorista']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'operador']);
    }

    public function update(User $user, Driver $driver): bool
    {
        if ($user->hasAnyRole(['superadmin', 'admin'])) return true;
        // Operador não pode editar registros alheios (sem ownership definido)
        if ($user->hasRole('motorista')) return $user->driver_id === $driver->id;
        return false;
    }

    public function delete(User $user, Driver $driver): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin']);
    }
}
