<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditLogger
{
    public static function log(string $action, ?object $model = null, array $oldValues = [], array $newValues = []): void
    {
        $user = Auth::user();
        $auditableLabel = null;
        if ($model) {
            // Tenta obter um label amigável do modelo
            $auditableLabel = $model->name
                ?? $model->title
                ?? $model->description
                ?? ($model->id ?? null);
        }

        AuditLog::create([
            'user_id' => $user?->id,
            'user_name' => $user?->name,
            'enterprise_id' => session('empresa_id'),
            'enterprise_name' => session('empresa_nome'),
            'branch_id' => session('filial_id'),
            'branch_name' => session('filial_nome'),
            'action' => $action,
            'auditable_type' => $model ? get_class($model) : null,
            'auditable_id' => $model->id ?? null,
            'auditable_label' => $auditableLabel,
            'ip_address' => request()?->ip(),
            'user_agent' => request()?->userAgent(),
            'old_values' => $oldValues ?: null,
            'new_values' => $newValues ?: null,
        ]);
    }
}
