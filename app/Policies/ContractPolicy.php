<?php

namespace App\Policies;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContractPolicy
{
    use HandlesAuthorization;
    /**
     * Determina quem pode ver a lista de contratos (index).
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('superadmin') || $user->hasRole('admin');
    }

    /**
     * Determina quem pode visualizar um contrato.
     */
    public function view(User $user, Contract $contract): bool
    {
        if ($user->hasRole('superadmin')) {
            return true;
        }

        if ($user->hasRole('admin')) {
            // Apenas empresas vinculadas ao admin
            return $user->enterprises->pluck('id')->contains($contract->enterprise_id);
        }

        // Demais cargos não visualizam contratos
        return false;
    }

    /**
     * Determina quem pode criar contratos.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('superadmin') || $user->hasRole('admin');
    }

    /**
     * Determina quem pode atualizar um contrato.
     */
    public function update(User $user, Contract $contract): bool
    {
        if ($user->hasRole('superadmin')) {
            return true;
        }

        if ($user->hasRole('admin')) {
            return $user->enterprises->pluck('id')->contains($contract->enterprise_id);
        }

        return false;
    }

    /**
     * Determina quem pode excluir um contrato.
     */
    public function delete(User $user, Contract $contract): bool
    {
        if ($user->hasRole('superadmin')) {
            return true;
        }

        if ($user->hasRole('admin')) {
            return $user->enterprises->pluck('id')->contains($contract->enterprise_id);
        }

        return false;
    }

    /**
     * Restore e forceDelete, normalmente só para superadmin (opcional).
     */
    public function restore(User $user, Contract $contract): bool
    {
        return $user->hasRole('superadmin');
    }

    public function forceDelete(User $user, Contract $contract): bool
    {
        return $user->hasRole('superadmin');
    }
}
