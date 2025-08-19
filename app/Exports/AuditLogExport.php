<?php

namespace App\Exports;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AuditLogExport implements FromQuery, WithHeadings, WithMapping, Responsable
{
    private Builder $query;

    public function __construct(Builder $query)
    {
        $this->query = $query->orderBy('id');
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return ['ID', 'Data', 'Usuário', 'Empresa', 'Filial', 'Ação', 'Modelo', 'Referência', 'IP'];
    }

    public function map($log): array
    {
        return [
            $log->id,
            $log->created_at,
            $log->user_name ?? optional($log->user)->name,
            $log->display_enterprise,
            $log->display_branch,
            \translate_action($log->action),
            \translate_model($log->auditable_type),
            $log->display_label,
            $log->ip_address,
        ];
    }
}
