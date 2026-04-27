@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3>🔎 Reporte por Fecha</h3>

    <form method="POST" action="{{ route('reportes.fecha.buscar') }}" class="mb-3">
        @csrf
        <input type="date" name="fecha" required>
        <button class="btn btn-primary">Buscar</button>
    </form>

    @isset($fecha)

    <div class="alert alert-success">
        📅 Fecha: {{ $fecha }} <br>
        💰 Total: Bs {{ $total }}
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

    @endisset

</div>
@endsection