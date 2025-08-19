<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Research extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'researches';

    protected $casts = [
        'api_response' => 'array',
        'processed_data' => 'array',
        'validity_date' => 'date',
    ];

    protected $fillable = [
        'solicitation_id',
        'driver_id',
        'vehicle_id',

        // Dados da API (genéricos)
        'api_provider',
        'api_response',
        'api_status',
        'processed_data',

        // Dados processados (sempre presentes)
        'validation_status',
        'validity_date',
        'score',
        'notes',

        // Dados específicos (mapeados da API)
        'document_number', // CPF, placa, etc.
        'document_type', // 'cpf', 'plate', 'renavam'
        'person_name',
        'document_status', // 'valid', 'invalid', 'expired'
        'restrictions',
        'infractions',
        'processes',
    ];

    /**
     * Relacionamento: Pesquisa pertence a uma solicitação.
     */
    public function solicitation()
    {
        return $this->belongsTo(Solicitation::class);
    }

    /**
     * Relacionamento: Pesquisa pode estar vinculada a um motorista.
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Relacionamento: Pesquisa pode estar vinculada a um veículo.
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Scope: Pesquisas válidas
     */
    public function scopeValid($query)
    {
        return $query->where('validation_status', 'valid')
            ->where('validity_date', '>', now());
    }

    /**
     * Scope: Pesquisas expiradas
     */
    public function scopeExpired($query)
    {
        return $query->where('validity_date', '<=', now());
    }

    /**
     * Scope: Por provedor de API
     */
    public function scopeByProvider($query, $provider)
    {
        return $query->where('api_provider', $provider);
    }

    /**
     * Verifica se a pesquisa está válida
     */
    public function isValid(): bool
    {
        return $this->validation_status === 'valid' &&
            $this->validity_date &&
            $this->validity_date->isFuture();
    }

    /**
     * Obtém os dias restantes até expiração
     */
    public function getDaysUntilExpiration(): ?int
    {
        if (!$this->validity_date) {
            return null;
        }

        return now()->diffInDays($this->validity_date, false);
    }

    /**
     * Obtém o status formatado
     */
    public function getStatusLabel(): string
    {
        return match ($this->validation_status) {
            'valid' => 'Válido',
            'invalid' => 'Inválido',
            'expired' => 'Expirado',
            'pending' => 'Pendente',
            default => 'Desconhecido',
        };
    }

    /**
     * Obtém o tipo de documento formatado
     */
    public function getDocumentTypeLabel(): string
    {
        return match ($this->document_type) {
            'cpf' => 'CPF',
            'plate' => 'Placa',
            'renavam' => 'RENAVAM',
            'cnh' => 'CNH',
            default => ucfirst($this->document_type ?? ''),
        };
    }
}
