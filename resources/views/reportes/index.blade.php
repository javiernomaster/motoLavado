@extends('layouts.app')

@section('content')

<div class="container mt-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">📊 Reporte de Trabajadores</h3>
            <small class="text-muted">Resumen del día {{ now()->format('d/m/Y') }}</small>
        </div>
    </div>

    {{-- TARJETAS --}}
    <div class="row mb-4">

        <div class="col-md-3">
            <div class="card card-box">
                <div class="card-body">
                    <h6 class="text-muted">Servicios Hoy</h6>
                    <h3 class="fw-bold text-primary">
                        {{ $totalServicios ?? 0 }}
                    </h3>
                </div>
                <div class="card-icon bg-blue">
                    <i class="bi bi-droplet"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-box">
                <div class="card-body">
                    <h6 class="text-muted">Ganancia Trabajadores</h6>
                    <h3 class="fw-bold text-success">
                        Bs. {{ number_format($gananciaTrabajadores ?? 0, 2) }}
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
                        {{ $trabajadores->count() }}
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
            <h5 class="mb-0">👷 Listado de Trabajadores</h5>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">

                    <thead class="table-light">
                        <tr>
                            <th>Trabajador</th>
                            <th>Servicios Hoy</th>
                            <th>Ganancia Hoy</th>
                            <th>Ganancia Sistema JM</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($trabajadores as $t)
                        <tr style="cursor:pointer"
                            onclick="window.location='{{ route('reportes.trabajador', $t->id) }}'">

                            <td class="fw-semibold">
                                <i class="bi bi-person-circle me-1"></i>
                                {{ $t->nombre }}
                            </td>

                            <td>
                                <span class="badge bg-primary rounded-pill px-3 py-2">
                                    {{ $t->total_hoy }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-success rounded-pill px-3 py-2">
                                    Bs. {{ number_format($t->ganancia_hoy, 2) }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                    Bs. {{ number_format($t->ganancia_sistema_hoy ?? 0, 2) }}
                                </span>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-muted py-5">
                                <i class="bi bi-inbox fs-1"></i>
                                <p class="mt-2 mb-0">No hay registros hoy</p>
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