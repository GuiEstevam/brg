<?php

if (!function_exists('translate_status')) {
    function translate_status($status)
    {
        return match ($status) {
            'active' => 'Ativa',
            'inactive' => 'Inativa',
            'pending' => 'Pendente',
            'canceled' => 'Cancelada',
            // Adicione outros status conforme necessário
            default => ucfirst($status),
        };
    }
}
