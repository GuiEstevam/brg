<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enterprise extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'cnpj',
        'name',
        'state_registration',
        'address',
        'number',
        'uf',
        'complement',
        'cep',
        'district',
        'city',
        'user_id',
        'responsible_name',
        'responsible_email',
        'responsible_phone',
        'status',
        'deactivated_at',
    ];

    // Relacionamentos
    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}
