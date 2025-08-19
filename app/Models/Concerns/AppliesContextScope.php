<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait AppliesContextScope
{
    public function scopeForCurrentEnterprise(Builder $query): Builder
    {
        $enterpriseId = session('empresa_id');
        if ($enterpriseId) {
            $query->where('enterprise_id', $enterpriseId);
        }
        return $query;
    }

    public function scopeForCurrentBranch(Builder $query): Builder
    {
        $branchId = session('filial_id');
        if ($branchId) {
            $query->where('branch_id', $branchId);
        }
        return $query;
    }
}
