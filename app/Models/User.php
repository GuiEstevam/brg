<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens,
        HasRoles,
        HasFactory,
        HasProfilePhoto,
        Notifiable,
        TwoFactorAuthenticatable,
        SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'deactivated_at',
        'driver_id',
        'vehicle_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'deactivated_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ===========================
    // Relacionamentos Eloquent
    // ===========================

    /**
     * Empresas às quais o usuário pertence (muitos-para-muitos).
     */
    public function enterprises(): BelongsToMany
    {
        return $this->belongsToMany(Enterprise::class);
    }

    /**
     * Filiais às quais o usuário pertence (muitos-para-muitos).
     */
    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class);
    }

    /**
     * Motorista vinculado (caso o usuário seja do tipo motorista).
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Veículo vinculado (caso o usuário seja do tipo veículo).
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Solicitações feitas pelo usuário.
     */
    public function solicitations(): HasMany
    {
        return $this->hasMany(Solicitation::class);
    }

    /**
     * Documentos enviados pelo usuário.
     */
    public function uploadedDocuments(): HasMany
    {
        return $this->hasMany(Document::class, 'uploaded_by_user_id');
    }

    /**
     * Documentos validados pelo usuário.
     */
    public function validatedDocuments(): HasMany
    {
        return $this->hasMany(Document::class, 'validated_by_user_id');
    }
}
