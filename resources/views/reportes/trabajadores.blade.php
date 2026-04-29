@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <div class="d-flex align-items-center mb-2 mb-md-0">
            <a href="{{ route('reportes.index') }}" class="btn btn-secondary me-2">
                ⬅ Volver a Reportes
            </a>
            <h3 class="mb-0">👷 Ganancias por Trabajador</h3>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <div class="btn-group" role="group">
                <a href="{{ route('reportes.trabajadores-diario') }}" class="btn btn-outline-primary">
                    📅 Diario
                </a>
                <a href="{{ route('reportes.trabajadores-semanal') }}" class="btn btn-outline-primary">
                    📈 Semanal
                </a>
                <a href="{{ route('reportes.trabajadores-mensual') }}" class="btn btn-outline-primary">
                    📊 Mensual
                </a>
            </div>
            <div class="btn-group" role="group">
                <a href="{{ route('reportes.trabajadores.excel', request()->query()) }}" class="btn btn-success">
                    📊 Excel
                </a>
                <a href="{{ route('reportes.trabajadores.pdf', request()->query()) }}" class="btn btn-danger">
                    📄 PDF
                </a>
            </div>
        </div>
        </div>
        {{-- FILTRO TRABAJADOR --}}
        <div class="card mt-3 shadow-sm border-0 rounded-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-6">
                        <label>Seleccionar Trabajador</label>
                        <select name="trabajador" class="form-select">
                            <option value="">Todos</option>
                            @foreach($trabajadores_disponibles ?? [] as $id => $nombre)
                                <option value="{{ $id }}" {{ request('trabajador') == $id ? 'selected' : '' }}>
                                    {{ $nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Desde</label>
                        <input type="date" name="desde" value="{{ request('desde') }}" class="form-control">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary w-100">Filtrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">

                    <thead class="table-dark">
                        <tr>
                            <th>Trabajador</th>
                            <th>Comisión (%)</th>
                            <th>Servicios Realizados</th>
                            <th>Total Generado</th>
                            <th>Ganancia del Trabajador</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($trabajadores as $t)
                            <tr>
                                <td>{{ $t['nombre'] }}</td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $t['porcentaje'] }}%
                                    </span>
                                </td>
                                <td>{{ $t['total_servicios'] }}</td>
                                <td>Bs. {{ number_format($t['total_generado'], 2) }}</td>
                                <td>
                                    <strong class="text-success">
                                        Bs. {{ number_format($t['ganancia'], 2) }}
                                    </strong>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-muted py-4">
                                    No hay datos registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    @if(count($trabajadores) > 0)
                    <tfoot class="table-secondary fw-bold">
                        <tr>
                            <td colspan="3" class="text-end">Total General:</td>
                            <td>Bs. {{ number_format($trabajadores->sum('total_generado'), 2) }}</td>
                            <td>Bs. {{ number_format($trabajadores->sum('ganancia'), 2) }}</td>
                        </tr>
                    </tfoot>
                    @endif

                </table>
            </div>
        </div>
    </div>

</div>

@endsection