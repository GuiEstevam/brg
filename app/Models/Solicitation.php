<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Solicitation extends Model
{
    use SoftDeletes;
    use \App\Models\Concerns\AppliesContextScope;
    use HasFactory;
    use \App\Observers\ModelAuditObserver {
        bootModelAudit as private __bootModelAudit;
    }

    protected $casts = [
        'api_request_data' => 'array',
        'auto_renewal' => 'boolean',
        'calculated_price' => 'decimal:2',
    ];

    protected $fillable = [
        'enterprise_id',
        'user_id',
        'branch_id',

        // Dados essenciais (sempre presentes)
        'entity_type', // 'driver', 'vehicle', 'composed'
        'entity_value', // CPF, placa, etc.
        'research_type', // 'basic', 'complete', 'express'
        'status', // 'pending', 'processing', 'completed', 'failed'

        // Dados de contexto
        'driver_id',
        'vehicle_id',
        'vincle_type', // 'autonomo', 'agregado', 'funcionario'

        // Dados da API
        'api_request_data',
        'calculated_price',
        'auto_renewal',
        'notes',
    ];

    protected static function boot()
    {
        parent::boot();
        static::__bootModelAudit();
    }

    /**
     * Relacionamento: Solicitação pertence a uma empresa.
     */
    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class);
    }

    /**
     * Relacionamento: Solicitação pertence a um usuário.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento: Solicitação pode pertencer a uma filial.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Relacionamento: Solicitação pode envolver um motorista.
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Relacionamento: Solicitação pode envolver um veículo.
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Relacionamento: Solicitação pode ter múltiplos veículos (pivô).
     */
    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class, 'solicitation_vehicle')
            ->withPivot(['vehicle_role', 'order', 'status', 'api_data'])
            ->withTimestamps();
    }

    /**
     * Relacionamento: Solicitação pode ter várias pesquisas.
     */
    public function researches()
    {
        return $this->hasMany(Research::class);
    }

    /**
     * Relacionamento: Solicitação original (para renovações).
     */
    public function originalSolicitation()
    {
        return $this->belongsTo(Solicitation::class, 'original_solicitation_id');
    }

    /**
     * Relacionamento: Solicitações de renovação.
     */
    public function renewalSolicitations()
    {
        return $this->hasMany(Solicitation::class, 'original_solicitation_id');
    }

    /**
     * Scope: Solicitações válidas (com pesquisa válida)
     */
    public function scopeValid($query)
    {
        return $query->whereHas('researches', function ($q) {
            $q->valid();
        });
    }

    /**
     * Scope: Solicitações expiradas
     */
    public function scopeExpired($query)
    {
        return $query->whereHas('researches', function ($q) {
            $q->expired();
        });
    }

    /**
     * Scope: Por tipo de entidade
     */
    public function scopeByEntityType($query, $entityType)
    {
        return $query->where('entity_type', $entityType);
    }

    /**
     * Scope: Por tipo de pesquisa
     */
    public function scopeByResearchType($query, $researchType)
    {
        return $query->where('research_type', $researchType);
    }

    /**
     * Verifica se a solicitação tem pesquisa válida
     */
    public function hasValidResearch(): bool
    {
        return $this->researches()->valid()->exists();
    }

    /**
     * Obtém a pesquisa mais recente
     */
    public function getLatestResearch()
    {
        return $this->researches()->latest()->first();
    }

    /**
     * Obtém o status formatado
     */
    public function getStatusLabel(): string
    {
        return match ($this->status) {
            'pending' => 'Pendente',
            'processing' => 'Processando',
            'completed' => 'Concluída',
            'failed' => 'Falhou',
            'cancelled' => 'Cancelada',
            default => 'Desconhecido',
        };
    }

    /**
     * Obtém o tipo de entidade formatado
     */
    public function getEntityTypeLabel(): string
    {
        return match ($this->entity_type) {
            'driver' => 'Motorista',
            'vehicle' => 'Veículo',
            'composed' => 'Composta',
            default => ucfirst($this->entity_type ?? ''),
        };
    }

    /**
     * Obtém o tipo de pesquisa formatado
     */
    public function getResearchTypeLabel(): string
    {
        return match ($this->research_type) {
            'basic' => 'Básica',
            'complete' => 'Completa',
            'express' => 'Expressa',
            default => ucfirst($this->research_type ?? ''),
        };
    }

    /**
     * Obtém o tipo de vínculo formatado
     */
    public function getVincleTypeLabel(): string
    {
        return match ($this->vincle_type) {
            'autonomo' => 'Autônomo',
            'agregado' => 'Agregado',
            'funcionario' => 'Funcionário',
            default => ucfirst($this->vincle_type ?? ''),
        };
    }

    /**
     * Verifica se é uma solicitação de motorista
     */
    public function isDriver(): bool
    {
        return $this->entity_type === 'driver';
    }

    /**
     * Verifica se é uma solicitação de veículo
     */
    public function isVehicle(): bool
    {
        return $this->entity_type === 'vehicle';
    }

    /**
     * Verifica se é uma solicitação composta
     */
    public function isComposed(): bool
    {
        return $this->entity_type === 'composed';
    }
}
