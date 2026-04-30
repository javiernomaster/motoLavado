@extends('layouts.app')

@section('content')

<div class="container mt-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">👷 {{ $trabajador->nombre }}</h3>
            <small class="text-muted">Detalle de servicios realizados</small>
        </div>

        <a href="{{ route('reportes.index') }}" class="btn btn-secondary btn-sm">
            ← Volver
        </a>
    </div>

    {{-- TARJETAS --}}
    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h4 class="text-primary">{{ $lavadosHoy->count() }}</h4>
                    <small>Servicios Hoy</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h4 class="text-warning">{{ $lavadosSemana->count() }}</h4>
                    <small>Servicios Semana</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h4 class="text-success">
                        Bs. {{ number_format($totalGanado,2) }}
                    </h4>
                    <small>Ganancia Total</small>
                </div>
            </div>
        </div>

    </div>

    {{-- TABLA --}}
    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">📋 Historial de Servicios</h5>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle text-center mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>Servicio</th>
                            <th>Cliente</th>
                            <th>Moto</th>
                            <th>Fecha</th>
                            <th>Precio</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($trabajador->lavados as $l)
                        <tr>

                            <td>{{ $l->servicio->nombre ?? '' }}</td>
                            <td>{{ $l->cliente->nombre ?? '' }}</td>
                            <td>{{ $l->moto->placa ?? '' }}</td>
                            <td>{{ $l->fecha }}</td>
                            <td class="text-success fw-bold">
                                Bs. {{ $l->precio_total }}
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-muted py-4">
                                No hay servicios registrados
                            </td>
                        </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

@endsection