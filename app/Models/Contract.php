<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Contract extends Model
{
    use SoftDeletes;
    use \App\Models\Concerns\AppliesContextScope;
    use HasFactory;
    use \App\Observers\ModelAuditObserver {
        bootModelAudit as private __bootModelAudit;
    }

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

    protected static function boot()
    {
        parent::boot();
        static::__bootModelAudit();
    }

    /**
     * Relacionamento: Um contrato pertence a uma empresa.
     */
    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class);
    }
}
