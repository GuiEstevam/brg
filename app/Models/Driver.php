<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'cpf',
        'name',
        'email',
        'phone',
        'birth_date',
        'mother_name',
        'rg_number',
        'rg_uf',
        'status',
    ];

    /**
     * Relacionamento: Um motorista pode ter vários documentos.
     */
    public function documents()
    {
        return $this->morphMany(Document::class, 'owner');
    }

    /**
     * Relacionamento: Um motorista pode ter uma CNH.
     */
    public function driverLicense()
    {
        return $this->hasOne(DriverLicense::class);
    }

    /**
     * Relacionamento: Um motorista pode ter várias solicitações.
     */
    public function solicitations()
    {
        return $this->hasMany(Solicitation::class);
    }

    /**
     * Relacionamento: Um motorista pode ter vários resultados de pesquisa.
     */
    public function researches()
    {
        return $this->hasMany(Research::class);
    }
}
