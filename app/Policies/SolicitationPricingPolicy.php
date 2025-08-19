<?php

namespace App\Policies;

use App\Models\SolicitationPricing;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SolicitationPricingPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole('superadmin') || $user->hasRole('admin');
    }

    public function view(User $user, SolicitationPricing $pricing): bool
    {
        if ($user->hasRole('superadmin')) return true;
        if ($user->hasRole('admin')) {
            return $user->enterprises->pluck('id')->contains($pricing->enterprise_id);
        }
        return false;
    }

    // Somente superadmin cria/edita/exclui; admin apenas visualiza
    public function create(User $user): bool
    {
        return $user->hasRole('superadmin');
    }
    public function update(User $user, SolicitationPricing $pricing): bool
    {
        return $user->hasRole('superadmin');
    }
    public function delete(User $user, SolicitationPricing $pricing): bool
    {
        return $user->hasRole('superadmin');
    }
}
