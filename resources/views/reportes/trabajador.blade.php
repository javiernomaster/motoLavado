@extends('layouts.app')

@section('content')

<div class="container mt-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">👷 {{ $trabajador->nombre }}</h3>
            <small class="text-muted">Servicios del día {{ now()->format('d/m/Y') }}</small>
        </div>
        <a href="{{ route('reportes.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    {{-- TARJETAS RESUMEN --}}
    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card card-box">
                <div class="card-body">
                    <h6 class="text-muted">Total Servicios</h6>
                    <h3 class="fw-bold text-primary">{{ $ordenes->count() }}</h3>
                </div>
                <div class="card-icon bg-blue">
                    <i class="bi bi-droplet"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-box">
                <div class="card-body">
                    <h6 class="text-muted">Ganancia Trabajador</h6>
                    <h3 class="fw-bold text-success">
                        @php
                            $comision = $trabajador->porcentaje_comision ?? 0;
                            $totalBruto = $ordenes->sum('precio_total');
                            $gananciaTrabajador = $totalBruto * $comision / 100;
                        @endphp
                        Bs. {{ number_format($gananciaTrabajador, 2) }}
                    </h3>
                </div>
                <div class="card-icon bg-green">
                    <i class="bi bi-cash"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-box">
                <div class="card-body">
                    <h6 class="text-muted">Ganancia Sistema JM</h6>
                    <h3 class="fw-bold text-warning">
                        Bs. {{ number_format($totalBruto - $gananciaTrabajador, 2) }}
                    </h3>
                </div>
                <div class="card-icon bg-warning">
                    <i class="bi bi-building"></i>
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
                            <th>Cliente</th>
                            <th>Moto</th>
                            <th>Servicio</th>
                            <th>Precio</th>
                            <th>Ganancia Trabajador</th>
                            <th>Ganancia JM</th>
                            <th>Estado</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($ordenes as $i => $orden)
                        @php
                            $com = $trabajador->porcentaje_comision ?? 0;
                            $ganTrabajador = $orden->precio_total * $com / 100;
                            $ganJM = $orden->precio_total - $ganTrabajador;
                        @endphp
                        <tr>
                            <td class="text-muted">{{ $i + 1 }}</td>

                            <td class="fw-semibold">
                                <i class="bi bi-person me-1"></i>
                                {{ $orden->cliente->nombre ?? '—' }}
                            </td>

                            <td>{{ $orden->moto->placa ?? '—' }}</td>

                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ $orden->servicio->nombre ?? '—' }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-success rounded-pill px-3 py-2">
                                    Bs. {{ number_format($orden->precio_total, 2) }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-primary rounded-pill px-3 py-2">
                                    Bs. {{ number_format($ganTrabajador, 2) }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                    Bs. {{ number_format($ganJM, 2) }}
                                </span>
                            </td>

                            <td>
                                @if(strtolower($orden->estado) === 'pagado')
                                    <span class="badge bg-success">Pagado</span>
                                @elseif(strtolower($orden->estado) === 'pendiente')
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                @else
                                    <span class="badge bg-secondary">{{ $orden->estado }}</span>
                                @endif
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-muted py-5">
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