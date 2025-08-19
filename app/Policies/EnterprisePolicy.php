<?php

namespace App\Policies;

use App\Models\Enterprise;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EnterprisePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole('superadmin') || $user->hasRole('admin');
    }

    public function view(User $user, Enterprise $enterprise): bool
    {
        if ($user->hasRole('superadmin')) return true;
        if ($user->hasRole('admin')) {
            return $user->enterprises->pluck('id')->contains($enterprise->id);
        }
        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('superadmin');
    }

    public function update(User $user, Enterprise $enterprise): bool
    {
        if ($user->hasRole('superadmin')) return true;
        if ($user->hasRole('admin')) {
            return $user->enterprises->pluck('id')->contains($enterprise->id);
        }
        return false;
    }

    public function delete(User $user, Enterprise $enterprise): bool
    {
        return $user->hasRole('superadmin');
    }
}
