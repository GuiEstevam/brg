<?php

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
