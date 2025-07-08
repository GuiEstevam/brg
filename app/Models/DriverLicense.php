<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class DriverLicense extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'renach_number',
        'register_number',
        'category',
        'issuance_date',
        'expiry_date',
        'performs_paid_activity',
        'moop_course',
        'local_issuance',
        'security_number',
        'ordinance',
        'restriction',
        'mirror_number',
        'total_points',
        'status_cnh_image',
        'status_message_cnh_image',
        'validation_status_document_image',
        'validation_status_cnh',
        'validation_status_security_number',
        'validation_status_uf',
        'validation_image_message',
    ];

    /**
     * Relacionamento: Uma CNH pertence a um motorista.
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
