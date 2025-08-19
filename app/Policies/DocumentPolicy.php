<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'operador']);
    }

    public function view(User $user, Document $document): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'operador', 'motorista', 'veiculo']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'operador']);
    }

    public function update(User $user, Document $document): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin']);
    }

    public function delete(User $user, Document $document): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin']);
    }
}
