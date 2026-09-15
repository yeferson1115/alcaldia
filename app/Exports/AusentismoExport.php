<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AusentismoExport implements FromCollection, WithHeadings
{
    protected $rows;

    public function __construct($rows)
    {
        $this->rows = $rows;
    }

    public function collection()
    {
        return collect($this->rows);
    }

    public function headings(): array
    {
        return [
            'Fecha',
            'Empleado',
            'Documento',
            'Dependencia',
            'Trabajado mañana (min)',
            'Ausente mañana (min)',
            'Trabajado tarde (min)',
            'Ausente tarde (min)',
            'Total trabajado (min)',
            'Total ausente (min)',
            'Estado',
            'Notas (marcas)'
        ];
    }
}
