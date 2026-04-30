@extends('layouts.app')

@section('content')

<style>
/* HEADER JM */
.jm-header {
    background: linear-gradient(135deg, #071a38 0%, #0b2f5b 45%, #114c8d 100%);
    color: #fff;
    padding: 22px 32px;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(7,26,56,.30);
    margin-bottom: 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.jm-header-left {
    display: flex;
    align-items: center;
    gap: 16px;
}
.jm-header-title {
    font-size: 20px;
    font-weight: 800;
}
.jm-header-subtitle {
    font-size: 13px;
    opacity: .8;
}
.jm-header-module {
    background: rgba(255,255,255,.15);
    padding: 5px 14px;
    border-radius: 50px;
    font-size: 13px;
}
.jm-date {
    font-size: 13px;
    opacity: .85;
    margin-top: 5px;
}
</style>

<div class="container mt-4">

    {{-- HEADER NUEVO --}}
    <div class="jm-header">
        <div class="jm-header-left">
            <img src="{{ asset('images/logoM.png') }}"
                 style="width:60px;height:60px;object-fit:contain;">
            <div>
                <div class="jm-header-title">SISTEMA JM</div>
                <div class="jm-header-subtitle">Panel de control</div>
            </div>
        </div>

        <div>
            <div class="jm-header-module">
                🏍 Módulo Motos
            </div>
            <div class="jm-date">
                {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM YYYY') }}
            </div>
        </div>
    </div>

    {{-- CABECERA ORIGINAL --}}
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

                <div class="card-header text-white"
                     style="background:linear-gradient(135deg,#0b2f5b,#114c8d);">
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

                <div class="card-header text-white"
                     style="background:linear-gradient(135deg,#0e3d74,#29c5d8);">
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

        <div class="card-header text-white"
             style="background:linear-gradient(135deg,#071a38,#114c8d);">
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
                                <td>
                                    <span class="badge bg-{{ $lavado->estado == 'completado' ? 'success' : 'warning' }}">
                                        {{ $lavado->estado }}
                                    </span>
                                </td>
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