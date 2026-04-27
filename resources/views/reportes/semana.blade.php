@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3>📊 Reporte de la Semana</h3>

    <div class="alert alert-primary">
        💰 Total ganado esta semana: <strong>Bs {{ $total }}</strong>
    </div>

    <div class="alert alert-info">
        👨‍🔧 Mejor trabajador (ID):
        <strong>{{ $topTrabajador->trabajador_id ?? 'Sin datos' }}</strong>
    </div>

    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>Cliente</th>
                <th>Moto</th>
                <th>Trabajador</th>
                <th>Total</th>
                <th>Fecha</th>
            </tr>
        </thead>

        <tbody>
            @foreach($servicios as $s)
                <tr>
                    <td>{{ $s->cliente->nombre ?? 'N/A' }}</td>
                    <td>{{ $s->moto->placa ?? 'N/A' }}</td>
                    <td>{{ $s->trabajador->nombre ?? 'N/A' }}</td>
                    <td>Bs {{ $s->precio_total }}</td>
                    <td>{{ $s->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection