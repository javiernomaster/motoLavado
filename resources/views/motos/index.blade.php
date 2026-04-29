@extends('layouts.app')

@section('content')

<div class="container mt-4">

    {{-- CABECERA --}}
    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary me-2">
                ⬅ Volver al inicio
            </a>

            <h3 class="mb-0 d-inline">🏍 Motos</h3>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('motos.papelera') }}" class="btn btn-outline-dark">
                🗑 Papelera
            </a>
            <a href="{{ route('motos.create') }}" class="btn btn-primary">
                ➕ Nueva Moto
            </a>
        </div>

    </div>

    {{-- CONTADOR --}}
    @if(isset($totalMotos))
    <div class="mb-2 text-muted">
        <small>Mostrando {{ $motos->firstItem() ?? 0 }} - {{ $motos->lastItem() ?? 0 }} de {{ $totalMotos }} moto(s)</small>
    </div>
    @endif

    {{-- BÚSQUEDA --}}
    <div class="card shadow-sm border-0 rounded-4 mb-3">
        <div class="card-body">
            <form action="{{ route('motos.index') }}" method="GET" class="row g-2">
                <div class="col-md-8">
                    <input type="text" name="buscar" value="{{ request('buscar') }}"
                           class="form-control" placeholder="Buscar por placa/marca/estado...">
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-outline-primary w-100">🔍 Buscar</button>
                    @if(request('buscar'))
                        <a href="{{ route('motos.index') }}" class="btn btn-outline-secondary w-100">Limpiar</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- PAGINACIÓN --}}
    <div class="d-flex justify-content-center mb-3">
        {{ $motos->appends(request()->query())->links() }}
    </div>

    {{-- TABLA --}}
    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle text-center">

                    <thead class="table-dark">
                        <tr>
                            <th>Placa</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Lavados</th>
                            <th>Cliente</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($motos as $m)

                            <tr>
                                <td class="fw-bold">{{ $m->placa }}</td>
                                <td>{{ $m->marca }}</td>
                                <td>{{ $m->modelo }}</td>
                                <td>
                                    <span class="badge bg-primary rounded-pill">
                                        {{ $m->lavados_count }} lavados
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ $m->cliente->nombre ?? 'Sin cliente' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $m->estado == 1 ? 'bg-success' : 'bg-danger' }} rounded-pill">
                                        {{ $m->estado == 1 ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>

                                {{-- ACCIONES --}}
                                <td class="d-flex justify-content-center gap-2">

                                    <a href="{{ route('motos.show', $m) }}" class="btn btn-info btn-sm">
                                         Ver
                                    </a>
                                    <a href="{{ route('motos.edit', $m) }}" class="btn btn-warning btn-sm">
                                         Editar
                                    </a>

                                    <form action="{{ route('motos.destroy', $m) }}" method="POST" class="form-eliminar d-inline">
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
                                    No hay motos registradas
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
        {{ $motos->appends(request()->query())->links() }}
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.form-eliminar').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Eliminar moto?',
                text: 'Se moverá a papelera.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Sí, eliminar'
            }).then(result => {
                if (result.isConfirmed) {
                    console.log('Submitting form'); // Debug
                    form.submit();
                }
            });
        });
    });
});
</script>

@endsection

