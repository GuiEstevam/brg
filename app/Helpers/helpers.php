<?php

use App\Helpers\PermissionHelper;
use Illuminate\Support\Facades\Auth;
use App\Models\Enterprise;
use App\Models\Branch;

if (!function_exists('translate_status')) {
    function translate_status($status)
    {
        return match ($status) {
            'active' => 'Ativa',
            'inactive' => 'Inativa',
            'pending' => 'Pendente',
            'canceled' => 'Cancelada',
            default => ucfirst($status),
        };
    }
}

if (!function_exists('status_badge_class')) {
    function status_badge_class($status)
    {
        return match ($status) {
            'active'   => 'badge-success',
            'inactive' => 'badge-secondary',
            'pending'  => 'badge-warning',
            'canceled' => 'badge-danger',
            'expired'  => 'badge-dark',
            default    => 'badge-secondary',
        };
    }
}

if (!function_exists('format_permission')) {
    function format_permission($permission)
    {
        return PermissionHelper::humanize($permission);
    }
}

if (!function_exists('entity_label')) {
    function entity_label($entity)
    {
        return PermissionHelper::entityLabel($entity);
    }
}

if (!function_exists('group_permissions_by_entity')) {
    function group_permissions_by_entity($permissions)
    {
        return PermissionHelper::groupPermissionsByEntity($permissions);
    }
}

if (!function_exists('entity_icon')) {
    function entity_icon(string $entity): string
    {
        return \App\Helpers\PermissionHelper::entityIcon($entity);
    }
}

// Tradução de tipos genéricos usados em múltiplas telas
if (!function_exists('translate_type')) {
    function translate_type(?string $type): string
    {
        if (!$type) return '-';
        $map = [
            // Documentos
            'cnh' => 'CNH',
            'crlv' => 'CRLV',
            'comprovante_residencia' => 'Comprovante de Residência',
            'contrato_social' => 'Contrato Social',
            'outro' => 'Outro',
            // Solicitações
            'pending' => 'Pendente',
            'processing' => 'Processando',
            'finished' => 'Finalizada',
            'error' => 'Erro',
            'normal' => 'Normal',
            'expressa' => 'Expressa',
            'pesquisa_plus' => 'Pesquisa +',
            'autonomo' => 'Autônomo',
            'agregado' => 'Agregado',
            'funcionario' => 'Funcionário',
            'pessoa_fisica' => 'Pessoa Física',
            'veiculo' => 'Veículo',
            'carreta' => 'Carreta',
        ];
        return $map[strtolower($type)] ?? ucfirst(str_replace('_', ' ', $type));
    }
}

if (!function_exists('translate_action')) {
    function translate_action(string $action): string
    {
        return match ($action) {
            'created' => 'Criado',
            'updated' => 'Atualizado',
            'deleted' => 'Excluído',
            'context_selected' => 'Contexto selecionado',
            'context_selected_empresa' => 'Empresa selecionada',
            'context_selected_filial' => 'Filial selecionada',
            'context_cleared' => 'Contexto limpo',
            default => ucfirst($action),
        };
    }
}

if (!function_exists('translate_model')) {
    function translate_model(?string $fqcn): string
    {
        if (!$fqcn) return '-';
        $name = class_basename($fqcn);
        return match ($name) {
            'Driver' => 'Motorista',
            'Vehicle' => 'Veículo',
            'Document' => 'Documento',
            'DriverLicense' => 'CNH',
            'Contract' => 'Contrato',
            'Enterprise' => 'Empresa',
            'Branch' => 'Filial',
            'Solicitation' => 'Solicitação',
            'SolicitationPricing' => 'Precificação',
            default => $name,
        };
    }
}

if (!function_exists('truncate_middle')) {
    function truncate_middle(?string $text, int $max = 20): string
    {
        if (!$text) return '-';
        if (mb_strlen($text) <= $max) return $text;
        $half = intdiv($max - 3, 2);
        return mb_substr($text, 0, $half) . '...' . mb_substr($text, -$half);
    }
}

// ==========================
// Context helpers (empresa/filial)
// ==========================
if (!function_exists('current_enterprise_id')) {
    function current_enterprise_id(): ?int
    {
        return session('empresa_id');
    }
}

if (!function_exists('current_branch_id')) {
    function current_branch_id(): ?int
    {
        return session('filial_id');
    }
}

if (!function_exists('current_enterprise')) {
    function current_enterprise(): ?Enterprise
    {
        $id = current_enterprise_id();
        return $id ? Enterprise::find($id) : null;
    }
}

if (!function_exists('current_branch')) {
    function current_branch(): ?Branch
    {
        $id = current_branch_id();
        return $id ? Branch::find($id) : null;
    }
}

if (!function_exists('user_is_superadmin')) {
    function user_is_superadmin(): bool
    {
        return Auth::check() && Auth::user()->hasRole('superadmin');
    }
}

if (!function_exists('user_is_admin')) {
    function user_is_admin(): bool
    {
        return Auth::check() && Auth::user()->hasRole('admin');
    }
}

if (!function_exists('get_entity_types')) {
    function get_entity_types(): array
    {
        return [
            'driver' => 'Motorista',
            'vehicle' => 'Veículo',
            'composed' => 'Composta (Motorista + Veículo)',
        ];
    }
}

if (!function_exists('get_research_types')) {
    function get_research_types(): array
    {
        return [
            'basic' => 'Básica',
            'complete' => 'Completa',
            'express' => 'Expressa',
        ];
    }
}

if (!function_exists('get_vincle_types')) {
    function get_vincle_types(): array
    {
        return [
            'autonomo' => 'Autônomo',
            'agregado' => 'Agregado',
            'funcionario' => 'Funcionário',
        ];
    }
}

if (!function_exists('get_validation_statuses')) {
    function get_validation_statuses(): array
    {
        return [
            'valid' => 'Válido',
            'invalid' => 'Inválido',
            'expired' => 'Expirado',
            'pending' => 'Pendente',
        ];
    }
}

if (!function_exists('get_document_types')) {
    function get_document_types(): array
    {
        return [
            'cpf' => 'CPF',
            'plate' => 'Placa',
            'renavam' => 'RENAVAM',
            'cnh' => 'CNH',
        ];
    }
}

if (!function_exists('get_document_statuses')) {
    function get_document_statuses(): array
    {
        return [
            'valid' => 'Válido',
            'invalid' => 'Inválido',
            'expired' => 'Expirado',
        ];
    }
}

/**
 * Obter classe CSS para badge de status
 */
function get_status_badge_class($status)
{
    return match ($status) {
        'pending' => 'bg-warning',
        'processing' => 'bg-info',
        'finished' => 'bg-success',
        'error' => 'bg-danger',
        default => 'bg-secondary',
    };
}

/**
 * Obter classe CSS para badge de tipo de entidade
 */
function get_entity_type_badge_class($entityType)
{
    return match ($entityType) {
        'driver' => 'bg-primary',
        'vehicle' => 'bg-success',
        'composed' => 'bg-warning',
        default => 'bg-secondary',
    };
}

/**
 * Obter label de status
 */
function get_status_label($status)
{
    return match ($status) {
        'pending' => 'Pendente',
        'processing' => 'Processando',
        'finished' => 'Finalizada',
        'error' => 'Erro',
        default => 'Desconhecido',
    };
}

/**
 * Obter label de tipo de entidade
 */
function get_entity_type_label($entityType)
{
    return match ($entityType) {
        'driver' => 'Motorista',
        'vehicle' => 'Veículo',
        'composed' => 'Composta',
        default => 'Desconhecido',
    };
}

/**
 * Obter label de tipo de pesquisa
 */
function get_research_type_label($researchType)
{
    return match ($researchType) {
        'basic' => 'Básica',
        'complete' => 'Completa',
        'express' => 'Expressa',
        default => 'Desconhecida',
    };
}

/**
 * Obter label de status de validação
 */
function get_validation_status_label($validationStatus)
{
    return match ($validationStatus) {
        'valid' => 'Válido',
        'invalid' => 'Inválido',
        'pending' => 'Pendente',
        'expired' => 'Expirado',
        default => 'Desconhecido',
    };
}

/**
 * Obter label de tipo de vínculo
 */
function get_vincle_type_label($vincleType)
{
    return match ($vincleType) {
        'autonomo' => 'Autônomo',
        'agregado' => 'Agregado',
        'funcionario' => 'Funcionário',
        default => 'Desconhecido',
    };
}
