@extends('layouts.app')

@section('content')

<div class="container">

    <h4 class="mb-4">Reporte de Lavados</h4>

    <form method="GET" action="{{ route('reportes.index') }}" class="row g-3 mb-4">

        <div class="col-md-3">
            <label>Cliente</label>
            <input type="text" name="cliente" value="{{ request('cliente') }}" class="form-control">
        </div>

        <div class="col-md-2">
            <label>Estado</label>
            <select name="estado" class="form-control">
                <option value="">Todos</option>
                <option value="Pendiente" {{ request('estado')=='Pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="En proceso" {{ request('estado')=='En proceso' ? 'selected' : '' }}>En proceso</option>
                <option value="Finalizado" {{ request('estado')=='Finalizado' ? 'selected' : '' }}>Finalizado</option>
            </select>
        </div>

        <div class="col-md-2">
            <label>Desde</label>
            <input type="date" name="desde" value="{{ request('desde') }}" class="form-control">
        </div>

        <div class="col-md-2">
            <label>Hasta</label>
            <input type="date" name="hasta" value="{{ request('hasta') }}" class="form-control">
        </div>

        <div class="col-md-3 d-flex align-items-end">
            <button class="btn btn-primary w-100">Filtrar</button>
        </div>

    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">

            <thead class="table-dark">
                <tr>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Placa</th>
                    <th>Servicio</th>
                    <th>Trabajador</th>
                    <th>Estado</th>
                    <th>Precio</th>
                </tr>
            </thead>

            <tbody>
                @foreach($lavados as $lavado)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($lavado->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $lavado->cliente->nombre ?? '' }}</td>
                    <td>{{ $lavado->moto->placa ?? '' }}</td>
                    <td>{{ $lavado->servicio->nombre ?? '' }}</td>
                    <td>{{ $lavado->trabajador->nombre ?? '' }}</td>
                    <td>{{ $lavado->estado }}</td>
                    <td>{{ $lavado->precio_total }}</td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>

@endsection