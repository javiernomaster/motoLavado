<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class TrabajadoresExport implements FromCollection, WithHeadings
{
    protected $trabajadores;

    public function __construct(Collection $trabajadores)
    {
        $this->trabajadores = $trabajadores;
    }

    public function collection()
    {
        return $this->trabajadores->map(function ($t) {
            return [
                $t['nombre'],
                $t['porcentaje'] . '%',
                $t['total_servicios'],
                $t['total_generado'],
                $t['ganancia'],
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Trabajador',
            'Comisión (%)',
            'Servicios Realizados',
            'Total Generado (Bs)',
            'Ganancia del Trabajador (Bs)',
        ];
    }
}
