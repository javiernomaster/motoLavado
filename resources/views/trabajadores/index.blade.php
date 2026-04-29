@extends('layouts.app')

@section('content')

<div class="container mt-4">

    {{-- CABECERA --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary me-2" type="button">
                ⬅ Volver al inicio
            </a>
            <h3 class="mb-0 d-inline">👨‍🔧 Trabajadores</h3>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('trabajadores.papelera') }}" class="btn btn-outline-dark" type="button">
                🗑 Papelera
            </a>
            <a href="{{ route('trabajadores.create') }}" class="btn btn-primary" type="button">
                ➕ Nuevo Trabajador
            </a>
        </div>
    </div>

    {{-- MENSAJES FLASH --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- BÚSQUEDA --}}
    <div class="card shadow-sm border-0 rounded-4 mb-3">
        <div class="card-body">
            <form action="{{ route('trabajadores.index') }}" method="GET" class="row g-2">
                <div class="col-md-8">
                    <input type="text" name="buscar" value="{{ request('buscar') }}"
                           class="form-control" placeholder="Buscar por nombre, CI o teléfono...">
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-outline-primary w-100">🔍 Buscar</button>
                    @if(request('buscar'))
                        <a href="{{ route('trabajadores.index') }}" class="btn btn-outline-secondary w-100" type="button">
                            Limpiar
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- CONTADOR --}}
    @if($trabajadores instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="mb-2 text-muted">
            <small>
                Mostrando {{ $trabajadores->firstItem() }}
                - {{ $trabajadores->lastItem() }}
                de {{ $trabajadores->total() }} trabajador(es)
            </small>
        </div>
    @endif

    {{-- TABLA --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>CI</th>
                            <th>Teléfono</th>
                            <th>Lavados</th>
                            <th>Comisión</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($trabajadores as $t)
                            <tr>
                                <td>{{ $t->id }}</td>
                                <td class="fw-semibold">{{ $t->nombre }}</td>
                                <td>{{ $t->ci }}</td>
                                <td>{{ $t->telefono }}</td>
                                <td>
                                    <span class="badge bg-primary rounded-pill">
                                        {{ $t->lavados_count ?? 0 }} lavados
                                    </span>
                                </td>
                                <td>{{ $t->porcentaje_comision }}%</td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">

                                        <a href="{{ route('trabajadores.show', $t->id) }}"
                                           class="btn btn-info btn-sm text-white" type="button">
                                             Ver
                                        </a>

                                        <a href="{{ route('trabajadores.edit', $t->id) }}"
                                           class="btn btn-warning btn-sm" type="button">
                                             Editar
                                        </a>

                                        <form action="{{ route('trabajadores.destroy', $t->id) }}"
                                              method="POST" class="form-eliminar d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                 Eliminar
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="7" class="text-muted py-4">
                                    @if(request('buscar'))
                                        No se encontraron resultados para la búsqueda.
                                    @else
                                        No hay trabajadores registrados.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINACIÓN (posición correcta) --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $trabajadores->appends(request()->query())->links() }}
            </div>

        </div>
    </div>

</div>

@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.form-eliminar').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Eliminar trabajador?',
                text: 'Se moverá a la papelera.',
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
@endpush