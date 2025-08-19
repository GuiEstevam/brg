<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class QueryExport implements FromQuery, WithHeadings, WithMapping
{
    private Builder $query;
    private array $headings;
    /** @var callable */
    private $mapper;

    public function __construct(Builder $query, array $headings, callable $mapper)
    {
        $this->query = $query->orderBy('id');
        $this->headings = $headings;
        $this->mapper = $mapper;
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return $this->headings;
    }

    public function map($row): array
    {
        return call_user_func($this->mapper, $row);
    }
}
