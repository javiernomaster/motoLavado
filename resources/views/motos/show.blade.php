@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('motos.index') }}" class="btn btn-secondary me-2">
                ⬅ Volver
            </a>
            <h3 class="mb-0 d-inline">🏍 {{ $moto->placa }}</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Información de la Moto</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3"><strong>Placa:</strong></div>
                        <div class="col-md-9">{{ $moto->placa }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><strong>Marca:</strong></div>
                        <div class="col-md-9">{{ $moto->marca }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><strong>Modelo:</strong></div>
                        <div class="col-md-9">{{ $moto->modelo }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><strong>Estado:</strong></div>
                        <div class="col-md-9">
                            <span class="badge {{ $moto->estado ? 'bg-success' : 'bg-danger' }}">
                                {{ $moto->estado ? 'Activa' : 'Inactiva' }}
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><strong>Cliente:</strong></div>
                        <div class="col-md-9">{{ $moto->cliente->nombre ?? 'Sin cliente' }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">📊 Estadísticas</h6>
                </div>
                <div class="card-body text-center">
                    <h2 class="text-primary">{{ $totalLavados }}</h2>
                    <p class="mb-1">Total Lavados</p>
                    <hr>
                    <h4 class="text-success">Bs. {{ number_format($ingresosGenerados, 2) }}</h4>
                    <p class="mb-0">Ingresos Generados</p>
                </div>
            </div>
        </div>
    </div>

    @if($moto->lavados->count() > 0)
    <div class="card shadow-sm border-0 rounded-4 mt-4">
        <div class="card-header bg-secondary text-white">
            <h6 class="mb-0">Últimos 10 Lavados</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Servicio</th>
                            <th>Estado</th>
                            <th>Ingreso</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($moto->lavados as $lavado)
                            <tr>
                                <td>{{ $lavado->fecha->format('d/m') }}</td>
                                <td>{{ $lavado->servicio->nombre ?? 'N/A' }}</td>
                                <td><span class="badge bg-{{ $lavado->estado == 'completado' ? 'success' : 'warning' }}">{{ $lavado->estado }}</span></td>
                                <td>Bs. {{ number_format($lavado->precio_total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection

