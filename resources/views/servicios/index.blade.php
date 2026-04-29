@extends('layouts.app')

@section('content')

<div class="container mt-4">

    {{-- CABECERA --}}
    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary me-2">
                ⬅ Volver al inicio
            </a>

            <h3 class="mb-0 d-inline">🧼 Servicios</h3>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('servicios.papelera') }}" class="btn btn-outline-dark">
                🗑 Papelera
            </a>
            <a href="{{ route('servicios.create') }}" class="btn btn-primary">
                ➕ Nuevo Servicio
            </a>
        </div>

    </div>

    {{-- CONTADOR --}}
    @if(isset($totalServicios))
    <div class="mb-2 text-muted">
        <small>Mostrando {{ $servicios->firstItem() ?? 0 }} - {{ $servicios->lastItem() ?? 0 }} de {{ $totalServicios }} servicio(s)</small>
    </div>
    @endif

    {{-- BÚSQUEDA --}}
    <div class="card shadow-sm border-0 rounded-4 mb-3">
        <div class="card-body">
            <form action="{{ route('servicios.index') }}" method="GET" class="row g-2">
                <div class="col-md-8">
                    <input type="text" name="buscar" value="{{ request('buscar') }}"
                           class="form-control" placeholder="Buscar por nombre o estado...">
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-outline-primary w-100">🔍 Buscar</button>
                    @if(request('buscar'))
                        <a href="{{ route('servicios.index') }}" class="btn btn-outline-secondary w-100">Limpiar</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- PAGINACIÓN --}}
    <div class="d-flex justify-content-center mb-3">
        {{ $servicios->appends(request()->query())->links() }}
    </div>

    {{-- TABLA --}}
    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle text-center">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Precio (Bs)</th>
                            <th>Tiempo</th>
                            <th>Lavados</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($servicios as $s)

                            <tr>
                                <td>{{ $s->id }}</td>
                                <td class="fw-semibold">{{ $s->nombre }}</td>
                                <td>Bs. {{ number_format($s->precio, 2) }}</td>
                                <td>{{ $s->tiempo_estimado ?? '—' }} min</td>
                                <td>
                                    <span class="badge bg-primary rounded-pill">
                                        {{ $s->lavados_count }} lavados
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $s->estado == 1 || $s->estado == 'activo' ? 'bg-success' : 'bg-danger' }} rounded-pill">
                                        {{ $s->estado == 1 || $s->estado == 'activo' ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>

                                {{-- ACCIONES --}}
                                <td class="d-flex justify-content-center gap-2">

                                    <a href="{{ route('servicios.show', $s) }}" class="btn btn-info btn-sm">
                                         Ver
                                    </a>
                                    <a href="{{ route('servicios.edit', $s) }}" class="btn btn-warning btn-sm">
                                         Editar
                                    </a>

                                    <form action="{{ route('servicios.destroy', $s) }}" method="POST" class="form-eliminar d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                             Eliminar
                                        </button>
                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="text-muted py-4">
                                    No hay servicios registrados
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    {{-- PAGINACIÓN --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $servicios->appends(request()->query())->links() }}
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.form-eliminar').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Eliminar servicio?',
                text: 'Se moverá a papelera.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Sí, eliminar'
            }).then(result => {
                if (result.isConfirmed) form.submit();
            });
        });
    });
});
</script>

@endsection
