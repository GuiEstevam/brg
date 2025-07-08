<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'enterprise_id',
        'plan_name',
        'start_date',
        'end_date',
        'status',
        'max_users',
        'max_queries',
        'unlimited_queries',
        'total_queries_used',
    ];

    /**
     * Relacionamento: Um contrato pertence a uma empresa.
     */
    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class);
    }
}
