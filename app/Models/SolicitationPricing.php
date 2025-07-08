<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class SolicitationPricing extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'enterprise_id',
        'individual_driver_price',
        'individual_vehicle_price',
        'unified_price',
        'individual_driver_recurring',
        'individual_vehicle_recurring',
        'unified_recurring',
        'validity_days',
        'price_expressa_driver',
        'price_normal_driver',
        'price_plus_driver',
        'price_expressa_vehicle',
        'price_normal_vehicle',
        'price_plus_vehicle',
        'price_expressa_unified',
        'price_normal_unified',
        'price_plus_unified',
        'unified_additional_per_vehicle_expressa',
        'unified_additional_per_vehicle_normal',
        'unified_additional_per_vehicle_plus',
        'validity_autonomo_days',
        'validity_agregado_days',
        'validity_funcionario_days',
        'description',
        'status',
    ];

    /**
     * Relacionamento: Precificação pertence a uma empresa.
     */
    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class);
    }
}
