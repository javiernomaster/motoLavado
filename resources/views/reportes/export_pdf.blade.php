<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }
        h2   { color: #0b2f5b; margin-bottom: 4px; }
        .sub { color: #888; font-size: 10px; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        thead th {
            background: #0b2f5b; color: #fff;
            padding: 7px 6px; text-align: center; font-size: 10px;
        }
        tbody td {
            padding: 6px; border-bottom: 1px solid #eee;
            text-align: center; font-size: 10px;
        }
        tbody tr:nth-child(even) { background: #f5f7fb; }
        .total { margin-top: 14px; text-align: right; font-weight: bold; color: #0b2f5b; }
    </style>
</head>
<body>
    <h2>📋 Registro JM — {{ $titulo }}</h2>
    <div class="sub">Generado: {{ now()->format('d/m/Y H:i') }}</div>

    <table>
        <thead>
            <tr>
                <th>#</th><th>Fecha</th><th>Cliente</th><th>Moto</th><th>Placa</th>
                <th>Servicio</th><th>Trabajador</th><th>Precio</th><th>Método</th><th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ordenes as $o)
            <tr>
                <td>{{ $o->id_orden }}</td>
                <td>{{ $o->fecha?->format('d/m/Y') ?? '—' }}</td>
                <td>{{ $o->cliente?->nombre ?? '—' }}</td>
                <td>{{ $o->moto ? $o->moto->marca.' '.$o->moto->modelo : '—' }}</td>
                <td>{{ $o->moto?->placa ?? '—' }}</td>
                <td>{{ $o->servicio?->nombre ?? '—' }}</td>
                <td>{{ $o->trabajador?->nombre ?? '—' }}</td>
                <td>Bs. {{ number_format($o->precio_total, 2) }}</td>
                <td>{{ $o->metodo_pago ?? '—' }}</td>
                <td>{{ $o->estado_pago ?? '—' }}</td>
            </tr>
            @empty
            <tr><td colspan="10" style="text-align:center;padding:20px;color:#aaa;">Sin registros</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="total">
        Total registros: {{ $ordenes->count() }} &nbsp;|&nbsp;
        Total recaudado: Bs. {{ number_format($ordenes->sum('precio_total'), 2) }}
    </div>
</body>
</html>