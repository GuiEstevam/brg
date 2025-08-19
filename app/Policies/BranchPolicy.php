<?php

namespace App\Policies;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BranchPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'operador']);
    }

    public function view(User $user, Branch $branch): bool
    {
        if ($user->hasRole('superadmin')) return true;
        if ($user->hasRole('admin') || $user->hasRole('operador')) {
            return $user->enterprises->pluck('id')->contains($branch->enterprise_id);
        }
        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin']);
    }

    public function update(User $user, Branch $branch): bool
    {
        if ($user->hasRole('superadmin')) return true;
        if ($user->hasRole('admin')) {
            return $user->enterprises->pluck('id')->contains($branch->enterprise_id);
        }
        return false;
    }

    public function delete(User $user, Branch $branch): bool
    {
        if ($user->hasRole('superadmin')) return true;
        if ($user->hasRole('admin')) {
            return $user->enterprises->pluck('id')->contains($branch->enterprise_id);
        }
        return false;
    }
}
