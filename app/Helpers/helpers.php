<?php

use App\Helpers\PermissionHelper;

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
