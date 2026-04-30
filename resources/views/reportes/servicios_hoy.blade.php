@extends('layouts.app')

@section('content')

<div class="container mt-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">🧾 Servicios del Día</h3>
            <small class="text-muted">{{ $hoy->format('d/m/Y') }}</small>
        </div>
        <a href="{{ route('reportes.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    {{-- RESUMEN --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card card-box">
                <div class="card-body">
                    <h6 class="text-muted">Total Servicios</h6>
                    <h3 class="fw-bold text-primary">{{ $lavados->count() }}</h3>
                </div>
                <div class="card-icon bg-blue">
                    <i class="bi bi-droplet"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-box">
                <div class="card-body">
                    <h6 class="text-muted">Total Recaudado</h6>
                    <h3 class="fw-bold text-success">
                        Bs. {{ number_format($lavados->sum('precio_total'), 2) }}
                    </h3>
                </div>
                <div class="card-icon bg-green">
                    <i class="bi bi-cash"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-box">
                <div class="card-body">
                    <h6 class="text-muted">Ganancia Sistema JM</h6>
                    <h3 class="fw-bold text-warning">
                        Bs. {{ number_format($gananciaSistema ?? 0, 2) }}
                    </h3>
                </div>
                <div class="card-icon bg-warning">
                    <i class="bi bi-building"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-box">
                <div class="card-body">
                    <h6 class="text-muted">Trabajadores Activos</h6>
                    <h3 class="fw-bold text-dark">
                        {{ $lavados->pluck('trabajador_id')->unique()->count() }}
                    </h3>
                </div>
                <div class="card-icon bg-orange">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLA --}}
    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">📋 Detalle de Servicios</h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Hora</th>
                            <th>Cliente</th>
                            <th>Moto</th>
                            <th>Servicio</th>
                            <th>Trabajador</th>
                            <th>Precio</th>
                            <th>Ganancia JM</th>
                            <th>Estado</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($lavados as $i => $lavado)
                        <tr>
                            <td class="text-muted">{{ $i + 1 }}</td>

                            <td>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($lavado->fecha)->format('H:i') }}
                                </small>
                            </td>

                            <td class="fw-semibold">
                                <i class="bi bi-person me-1"></i>
                                {{ $lavado->cliente->nombre ?? '—' }}
                            </td>

                            <td>
                                {{ $lavado->moto->placa ?? '—' }}
                            </td>

                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ $lavado->servicio->nombre ?? '—' }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-secondary rounded-pill px-3 py-2">
                                    {{ $lavado->trabajador->nombre ?? '—' }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-success rounded-pill px-3 py-2">
                                    Bs. {{ number_format($lavado->precio_total, 2) }}
                                </span>
                            </td>

                            <td>
                                @php
                                    $comision = $lavado->trabajador->porcentaje_comision ?? 0;
                                    $gananciaJM = $lavado->precio_total - ($lavado->precio_total * $comision / 100);
                                @endphp
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                    Bs. {{ number_format($gananciaJM, 2) }}
                                </span>
                            </td>

                            <td>
                                @if($lavado->estado === 'pagado')
                                    <span class="badge bg-success">Pagado</span>
                                @elseif($lavado->estado === 'pendiente')
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                @else
                                    <span class="badge bg-secondary">{{ $lavado->estado }}</span>
                                @endif
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-muted py-5">
                                <i class="bi bi-inbox fs-1"></i>
                                <p class="mt-2 mb-0">No hay servicios registrados hoy</p>
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