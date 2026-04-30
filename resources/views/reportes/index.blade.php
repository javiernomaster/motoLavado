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

    {{-- HEADER JM --}}
    <div class="jm-header">

        <div class="jm-header-left">
            <img src="{{ asset('images/logoM.png') }}"
                 style="width:60px;height:60px;object-fit:contain;">

            <div>
                <div class="jm-header-title">SISTEMA JM</div>
                <div class="jm-header-subtitle">Panel de control</div>
            </div>
        </div>

        <div class="text-end">
            <div class="jm-header-module">
                📊 Reporte de Trabajadores
            </div>
            <div class="jm-date">
                {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM YYYY') }}
            </div>
        </div>

    </div>

    {{-- TARJETAS --}}
    <div class="row mb-4">

        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h6 class="text-muted">Servicios Hoy</h6>
                    <h3 class="fw-bold text-primary">
                        {{ $totalServicios ?? 0 }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h6 class="text-muted">Ganancia Trabajadores</h6>
                    <h3 class="fw-bold text-success">
                        Bs. {{ number_format($gananciaTrabajadores ?? 0, 2) }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h6 class="text-muted">Ganancia Sistema JM</h6>
                    <h3 class="fw-bold text-warning">
                        Bs. {{ number_format($gananciaSistema ?? 0, 2) }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h6 class="text-muted">Trabajadores Activos</h6>
                    <h3 class="fw-bold text-dark">
                        {{ $trabajadores->count() }}
                    </h3>
                </div>
            </div>
        </div>

    </div>

    {{-- TABLA --}}
    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-header text-white"
             style="background:linear-gradient(135deg,#0b2f5b,#114c8d);">
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