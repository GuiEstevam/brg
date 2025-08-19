<?php

namespace App\Policies;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\AuditLog;

class PolicyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::policy(AuditLog::class, AuditLogPolicy::class);
    }
}
