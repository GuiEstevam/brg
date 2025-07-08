<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Solicitation extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $casts = [
    'api_request_data' => 'array',
    ];

    protected $fillable = [
        'enterprise_id',
        'user_id',
        'branch_id',
        'driver_id',
        'vehicle_id',
        'type',
        'subtype',
        'value',
        'status',
        'vincle_type',
        'research_type',
        'original_solicitation_id',
        'api_request_data',
    ];

    /**
     * Relacionamento: Solicitação pertence a uma empresa.
     */
    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class);
    }

    /**
     * Relacionamento: Solicitação pertence a um usuário.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento: Solicitação pode pertencer a uma filial.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Relacionamento: Solicitação pode envolver um motorista.
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Relacionamento: Solicitação pode envolver um veículo principal.
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Relacionamento: Solicitação pode ter múltiplos veículos (pivô).
     */
    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class, 'solicitation_vehicle');
    }

    /**
     * Relacionamento: Solicitação pode ser derivada de outra.
     */
    public function originalSolicitation()
    {
        return $this->belongsTo(Solicitation::class, 'original_solicitation_id');
    }

    /**
     * Relacionamento: Solicitação pode ter vários resultados de pesquisa.
     */
    public function researches()
    {
        return $this->hasMany(Research::class);
    }
}
