<?php

namespace App\Policies;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AuditLogPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin']);
    }

    public function view(User $user, AuditLog $log): bool
    {
        if ($user->hasRole('superadmin')) return true;
        if ($user->hasRole('admin')) {
            return $user->enterprises->pluck('id')->contains($log->enterprise_id);
        }
        return false;
    }
}
