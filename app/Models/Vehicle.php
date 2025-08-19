<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Vehicle extends Model
{
    use SoftDeletes;
    use HasFactory;
    use \App\Observers\ModelAuditObserver {
        bootModelAudit as private __bootModelAudit;
    }

    protected $fillable = [
        'plate',
        'renavam',
        'chassi',
        'brand',
        'model',
        'manufacture_year',
        'model_year',
        'color',
        'fuel',
        'vehicle_type',
        'vehicle_specie',
        'licensing_date',
        'licensing_status',
        'owner_document',
        'owner_name',
        'lessee_document',
        'lessee_name',
        'antt_situation',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();
        static::__bootModelAudit();
    }

    /**
     * Relacionamento: Um veículo pode ter vários documentos.
     */
    public function documents()
    {
        return $this->morphMany(Document::class, 'owner');
    }

    /**
     * Relacionamento: Um veículo pode ter várias solicitações.
     */
    public function solicitations()
    {
        return $this->hasMany(Solicitation::class);
    }

    /**
     * Relacionamento: Um veículo pode ter vários resultados de pesquisa.
     */
    public function researches()
    {
        return $this->hasMany(Research::class);
    }
}
