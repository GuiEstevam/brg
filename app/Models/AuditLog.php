<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Enterprise;
use App\Models\Branch;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'enterprise_id',
        'branch_id',
        'action',
        'auditable_type',
        'auditable_id',
        'ip_address',
        'user_agent',
        'old_values',
        'new_values',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDisplayEnterpriseAttribute(): string
    {
        if ($this->enterprise_name) {
            return $this->enterprise_name;
        }
        if ($this->enterprise_id) {
            $name = optional(Enterprise::find($this->enterprise_id))->name;
            return $name ?: (string) $this->enterprise_id;
        }
        return '-';
    }

    public function getDisplayBranchAttribute(): string
    {
        if ($this->branch_name) {
            return $this->branch_name;
        }
        if ($this->branch_id) {
            $name = optional(Branch::find($this->branch_id))->name;
            return $name ?: (string) $this->branch_id;
        }
        return '-';
    }

    public function getDisplayLabelAttribute(): string
    {
        if ($this->auditable_label) {
            return (string) $this->auditable_label;
        }
        if ($this->auditable_type && $this->auditable_id) {
            try {
                $model = app($this->auditable_type)::find($this->auditable_id);
                if ($model) {
                    return (string) ($model->name ?? $model->title ?? $model->description ?? $this->auditable_id);
                }
            } catch (\Throwable $e) {
                // ignore fallback
            }
        }
        return (string) ($this->auditable_id ?? '-');
    }
}
