<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Research extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'solicitation_id',
        'driver_id',
        'vehicle_id',
        'api_response',
        'status_api',
        'validity_date',
        'rejection_reasons',
        'total_points',
    ];

    /**
     * Relacionamento: Pesquisa pertence a uma solicitação.
     */
    public function solicitation()
    {
        return $this->belongsTo(Solicitation::class);
    }

    /**
     * Relacionamento: Pesquisa pode estar vinculada a um motorista.
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Relacionamento: Pesquisa pode estar vinculada a um veículo.
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
