<?php

namespace App\Policies;

use App\Models\Solicitation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SolicitationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'operador', 'motorista', 'veiculo']);
    }

    public function view(User $user, Solicitation $s): bool
    {
        if ($user->hasRole('superadmin')) return true;
        if ($user->hasRole('admin')) {
            return $user->enterprises->pluck('id')->contains($s->enterprise_id);
        }
        if ($user->hasRole('operador')) {
            return session('empresa_id') == $s->enterprise_id && (!session('filial_id') || session('filial_id') == $s->branch_id);
        }
        if ($user->hasRole('motorista')) {
            return $user->driver_id && $user->driver_id == $s->driver_id;
        }
        if ($user->hasRole('veiculo')) {
            return $s->vehicles()->where('vehicles.id', $user->vehicle_id)->exists();
        }
        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'operador']);
    }

    public function update(User $user, Solicitation $s): bool
    {
        if ($user->hasRole('superadmin')) return true;
        if ($user->hasRole('admin')) {
            return $user->enterprises->pluck('id')->contains($s->enterprise_id);
        }
        if ($user->hasRole('operador')) {
            return session('empresa_id') == $s->enterprise_id && (!session('filial_id') || session('filial_id') == $s->branch_id);
        }
        return false;
    }

    public function delete(User $user, Solicitation $s): bool
    {
        if ($user->hasRole('superadmin')) return true;
        if ($user->hasRole('admin')) {
            return session('empresa_id') == $s->enterprise_id; // opcional com mais regras de status
        }
        return false;
    }
}
