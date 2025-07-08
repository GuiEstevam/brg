<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'file_path',
        'document_type',
        'original_name',
        'mime_type',
        'size',
        'expiration_date',
        'status',
        'owner_id',
        'owner_type',
        'uploaded_by_user_id',
        'validated_by_user_id',
    ];

    /**
     * Relacionamento polimórfico: Documento pode pertencer a Driver ou Vehicle.
     */
    public function owner()
    {
        return $this->morphTo();
    }

    /**
     * Usuário que fez o upload do documento.
     */
    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by_user_id');
    }

    /**
     * Usuário que validou o documento.
     */
    public function validatedBy()
    {
        return $this->belongsTo(User::class, 'validated_by_user_id');
    }
}
