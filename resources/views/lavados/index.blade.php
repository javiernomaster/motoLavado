<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Trabajadores</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Iconos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }

        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .card-icon {
            font-size: 28px;
            padding: 12px;
            border-radius: 12px;
            color: #fff;
        }

        .bg-blue { background: #3b82f6; }
        .bg-green { background: #10b981; }
        .bg-orange { background: #f59e0b; }

        .table-hover tbody tr:hover {
            background-color: #f1f5f9;
            transform: scale(1.01);
            transition: 0.2s;
        }

        .badge-pill {
            padding: 8px 14px;
            border-radius: 50px;
            font-size: 14px;
        }

    </style>
</head>

<body>

<div class="container py-5">

    {{-- TITULO --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">📊 Reporte de Trabajadores</h3>
        <span class="badge bg-dark fs-6">
            {{ now()->format('d/m/Y') }}
        </span>
    </div>

    {{-- TARJETAS --}}
    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card card-custom p-3 d-flex flex-row align-items-center">
                <div class="card-icon bg-blue me-3">
                    <i class="bi bi-droplet"></i>
                </div>
                <div>
                    <h6 class="mb-0 text-muted">Servicios Hoy</h6>
                    <h4 class="fw-bold">{{ $trabajadores->sum('total_hoy') }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-custom p-3 d-flex flex-row align-items-center">
                <div class="card-icon bg-green me-3">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div>
                    <h6 class="mb-0 text-muted">Ganancia Total</h6>
                    <h4 class="fw-bold text-success">
                        Bs. {{ number_format($trabajadores->sum('ganancia_hoy'),2) }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-custom p-3 d-flex flex-row align-items-center">
                <div class="card-icon bg-orange me-3">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <h6 class="mb-0 text-muted">Trabajadores</h6>
                    <h4 class="fw-bold">{{ $trabajadores->count() }}</h4>
                </div>
            </div>
        </div>

    </div>

    {{-- TABLA --}}
    <div class="card card-custom">

        <div class="card-header bg-primary text-white rounded-top">
            <h5 class="mb-0">👷 Listado de Trabajadores</h5>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover text-center align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>Trabajador</th>
                            <th>Servicios Hoy</th>
                            <th>Ganancia Hoy</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($trabajadores as $t)
                        <tr style="cursor:pointer"
                            onclick="window.location='/reportes/trabajador/{{ $t->id }}'">

                            <td class="fw-semibold">
                                <i class="bi bi-person-circle me-1"></i>
                                {{ $t->nombre }}
                            </td>

                            <td>
                                <span class="badge bg-primary badge-pill">
                                    {{ $t->total_hoy }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-success badge-pill">
                                    Bs. {{ number_format($t->ganancia_hoy,2) }}
                                </span>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-muted py-4">
                                <i class="bi bi-inbox fs-3"></i>
                                <p class="mb-0 mt-2">No hay datos disponibles</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

</body>
</html>