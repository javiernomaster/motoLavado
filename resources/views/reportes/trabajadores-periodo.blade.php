@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('reportes.index') }}" class="btn btn-secondary me-2">
                ⬅ Volver a Reportes
            </a>
            <h3 class="mb-0 d-inline">👷 Reporte {{ $periodo ?? 'Período' }}</h3>
        </div>
    </div>

    {{-- FILTROS --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label>Trabajador</label>
                    <select name="trabajador" class="form-select">
                        <option value="">Todos los trabajadores</option>
                        @foreach($trabajadores_disponibles ?? [] as $t)
                            <option value="{{ $t->id }}" {{ request('trabajador') == $t->id ? 'selected' : '' }}>
                                {{ $t->nombre }} {{ $t->apellido }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Desde</label>
                    <input type="date" name="desde" value="{{ request('desde') }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>Hasta</label>
                    <input type="date" name="hasta" value="{{ request('hasta') }}" class="form-control">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                </div>
            </form>
        </div>
    </div>

    {{-- TABLA --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Trabajador</th>
                            <th>Comisión %</th>
                            <th>Servicios</th>
                            <th>Total Generado</th>
                            <th>Ganancia {{ $periodo ?? '' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trabajadores as $t)
                            <tr>
                                <td>{{ $t['nombre'] }}</td>
                                <td><span class="badge bg-primary">{{ $t['porcentaje'] }}%</span></td>
                                <td>{{ $t['total_servicios'] }}</td>
                                <td>Bs. {{ number_format($t['total_generado'], 2) }}</td>
                                <td class="fw-bold text-success">Bs. {{ number_format($t['ganancia'], 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-muted py-4">No hay datos para este período</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if(count($trabajadores) > 0)
                    <tfoot class="table-success fw-bold">
                        <tr>
                            <td colspan="2" class="text-end">TOTAL:</td>
                            <td>{{ $trabajadores->sum('total_servicios') }}</td>
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

