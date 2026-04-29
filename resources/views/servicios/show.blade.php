@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- CABECERA --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('servicios.index') }}" class="btn btn-secondary me-2">
                ⬅ Volver
            </a>
            <h3 class="mb-0 d-inline">🧼 {{ $servicio->nombre }}</h3>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('servicios.edit', $servicio) }}" class="btn btn-warning">
                ✏️ Editar
            </a>
            <form action="{{ route('servicios.destroy', $servicio) }}" method="POST" class="form-eliminar d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">🗑 Eliminar</button>
            </form>
        </div>
    </div>

    {{-- ESTADÍSTICAS --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h3 class="mb-0">{{ $totalLavados }}</h3>
                    <small class="text-muted">Total Lavados</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h3 class="mb-0">Bs. {{ number_format($ingresosGenerados, 2) }}</h3>
                    <small class="text-muted">Ingresos Generados</small>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h3 class="mb-0">
                        <span class="badge {{ $servicio->estado == 'activo' ? 'bg-success' : 'bg-danger' }}">
                            {{ ucfirst($servicio->estado) }}
                        </span>
                    </h3>
                    <small class="text-muted">Estado</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- INFORMACIÓN --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle"></i> Detalles</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr><td class="fw-semibold text-muted">Descripción:</td><td>{{ $servicio->descripcion ?? '—' }}</td></tr>
                        <tr><td class="fw-semibold text-muted">Precio:</td><td>Bs. {{ number_format($servicio->precio, 2) }}</td></tr>
                        <tr><td class="fw-semibold text-muted">Tiempo:</td><td>{{ $servicio->tiempo_estimado ?? '—' }} min</td></tr>
                        <tr><td class="fw-semibold text-muted">Creado:</td><td>{{ $servicio->created_at->format('d/m/Y') }}</td></tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- HISTORIAL LAVADOS --}}
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Lavados Recientes ({{ $totalLavados }})</h5>
                </div>
                <div class="card-body p-0">
                    @if($servicio->lavados->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Cliente</th>
                                        <th>Moto</th>
                                        <th>Precio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($servicio->lavados->sortByDesc('fecha')->take(10) as $lavado)
                                        <tr style="cursor: pointer;" onclick="window.location='{{ route('lavados.show', $lavado->id_orden) }}'">
                                            <td>{{ $lavado->fecha->format('d/m/Y') }}</td>
                                            <td>{{ $lavado->cliente->nombre }}</td>
                                            <td>{{ $lavado->moto->placa }}</td>
                                            <td>Bs. {{ number_format($lavado->precio_total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1"></i>
                            <p class="mt-2">No hay lavados con este servicio</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

<script>
document.querySelectorAll('.form-eliminar').forEach(form => {
    form.addEventListener('submit', e => {
        e.preventDefault();
        Swal.fire({
            title: '¿Eliminar servicio?',
            text: 'No podrá usarse en nuevos lavados.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar'
        }).then(result => {
            if (result.isConfirmed) form.submit();
        });
    });
});
</script>

@endsection

