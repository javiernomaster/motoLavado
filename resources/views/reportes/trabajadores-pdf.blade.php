<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Ganancias por Trabajador - {{ $periodo ?? 'General' }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .header { text-align: center; margin-bottom: 20px; }
        .total { font-weight: bold; background-color: #e8f4f8; }
        .ganancia { color: green; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Reporte de Ganancias por Trabajador</h2>
        <p>Periodo: {{ $periodo ?? 'General' }}</p>
        <p>Fecha de Generación: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Trabajador</th>
                <th>Comisión (%)</th>
                <th>Servicios</th>
                <th>Total Generado</th>
                <th>Ganancia</th>
            </tr>
        </thead>
        <tbody>
            @forelse($trabajadores as $t)
            <tr>
                <td>{{ $t['nombre'] }}</td>
                <td>{{ $t['porcentaje'] }}%</td>
                <td>{{ $t['total_servicios'] }}</td>
                <td>Bs. {{ number_format($t['total_generado'], 2) }}</td>
                <td class="ganancia">Bs. {{ number_format($t['ganancia'], 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">No hay datos</td>
            </tr>
            @endforelse
        </tbody>
        @if(count($trabajadores) > 0)
        <tfoot>
            <tr class="total">
                <td colspan="3">TOTAL GENERAL</td>
                <td>Bs. {{ number_format($trabajadores->sum('total_generado'), 2) }}</td>
                <td>Bs. {{ number_format($trabajadores->sum('ganancia'), 2) }}</td>
            </tr>
        </tfoot>
        @endif
    </table>
</body>
</html>
