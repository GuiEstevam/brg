<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'enterprise_id',
        'name',
        'cnpj',
        'address',
        'number',
        'uf',
        'cep',
        'district',
        'city',
        'phone',
        'email',
        'status',
    ];

    /**
     * Relacionamento: Uma filial pertence a uma empresa (Enterprise).
     */
    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class);
    }

    /**
     * Relacionamento: Uma filial pode ter muitos usuários.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relacionamento: Uma filial pode ter muitas solicitações.
     */
    public function solicitations()
    {
        return $this->hasMany(Solicitation::class);
    }
}
