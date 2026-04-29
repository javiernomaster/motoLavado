@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('reportes.index') }}" class="btn btn-secondary me-2">
                ⬅ Volver a Reportes
            </a>
            <h3 class="mb-0 d-inline">📊 Ganancias Trabajadores - HOY</h3>
        </div>
        <div class="btn-group me-3" role="group">
            <a href="{{ route('reportes.trabajadores.excel?periodo=Diario') }}" class="btn btn-success">
                📊 Excel
            </a>
            <a href="{{ route('reportes.trabajadores.pdf?periodo=Diario') }}" class="btn btn-danger">
                📄 PDF
            </a>
        </div>
        <a href="{{ route('reportes.trabajadores') }}" class="btn btn-outline-primary">
            Ver Totales
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-success text-white">
            <h6 class="mb-0"><i class="bi bi-calendar-day"></i> {{ now()->format('d/m/Y') }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Trabajador</th>
                            <th>Servicios Hoy</th>
                            <th>Total Generado</th>
                            <th>Ganancia ({{ $periodo }})</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trabajadores as $t)
                            <tr>
                                <td>{{ $t['nombre'] }}</td>
                                <td><span class="badge bg-primary">{{ $t['total_servicios'] }}</span></td>
                                <td>Bs. {{ number_format($t['total_generado'], 2) }}</td>
                                <td class="fw-bold text-success">Bs. {{ number_format($t['ganancia'], 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-4 text-muted">Sin servicios hoy</td></tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-dark fw-bold">
                        <tr>
                            <td>Total General</td>
                            <td>{{ $trabajadores->sum('total_servicios') }}</td>
                            <td>Bs. {{ number_format($trabajadores->sum('total_generado'), 2) }}</td>
                            <td>Bs. {{ number_format($trabajadores->sum('ganancia'), 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection

