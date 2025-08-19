<?php

namespace App\Policies;

use App\Models\DriverLicense;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DriverLicensePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'operador']);
    }

    public function view(User $user, DriverLicense $license): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'operador', 'motorista']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'operador']);
    }

    public function update(User $user, DriverLicense $license): bool
    {
        if ($user->hasAnyRole(['superadmin', 'admin'])) return true;
        if ($user->hasRole('motorista')) return $user->driver_id === $license->driver_id;
        return false;
    }

    public function delete(User $user, DriverLicense $license): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin']);
    }
}
