<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enterprise extends Model
{
    use SoftDeletes, HasFactory;

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

    public function solicitationPricings()
    {
        return $this->hasMany(SolicitationPricing::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
