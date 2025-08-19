<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SolicitationPricing extends Model
{
    use SoftDeletes, HasFactory, \App\Models\Concerns\AppliesContextScope;
    use \App\Observers\ModelAuditObserver {
        bootModelAudit as private __bootModelAudit;
    }

    protected $fillable = [
        'enterprise_id',
        'description',
        'individual_driver_price',
        'individual_vehicle_price',
        'unified_price',
        'unified_additional_vehicle_2',
        'unified_additional_vehicle_3',
        'unified_additional_vehicle_4',
        'recurrence_autonomo',
        'recurrence_agregado',
        'recurrence_frota',
        'validity_days',
        'validity_autonomo_days',
        'validity_agregado_days',
        'validity_funcionario_days',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();
        static::__bootModelAudit();
    }

    /**
     * Relacionamento: Precificação pertence a uma empresa.
     */
    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class);
    }
}
