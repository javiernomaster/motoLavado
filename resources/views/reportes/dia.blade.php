@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3>📅 Reporte del Día</h3>

    <div class="alert alert-success">
        💰 Total ganado hoy: <strong>Bs {{ $total }}</strong>
    </div>

    <div class="alert alert-info">
        👨‍🔧 Trabajador más activo:
        <strong>{{ $topTrabajador->trabajador_id ?? 'Sin datos' }}</strong>
    </div>

    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>Cliente</th>
                <th>Moto</th>
                <th>Trabajador</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>
            @foreach($servicios as $s)
                <tr>
                    <td>{{ $s->cliente->nombre ?? 'N/A' }}</td>
                    <td>{{ $s->moto->placa ?? 'N/A' }}</td>
                    <td>{{ $s->trabajador->nombre ?? 'N/A' }}</td>
                    <td>Bs {{ $s->precio_total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection