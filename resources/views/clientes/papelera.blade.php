@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- CABECERA --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('clientes.index') }}" class="btn btn-secondary me-2">
                ⬅ Volver
            </a>
            <h3 class="mb-0 d-inline">🗑 Papelera de Clientes</h3>
        </div>
    </div>

    {{-- MENSAJES FLASH --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                            <th>Motos</th>
                            <th>Eliminado el</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clientes as $c)
                            <tr>
                                <td>{{ $c->id }}</td>
                                <td class="fw-semibold">{{ $c->nombre }}</td>
                                <td>{{ $c->ci }}</td>
                                <td>{{ $c->telefono }}</td>
                                <td>
                                    <span class="badge bg-secondary rounded-pill">{{ $c->motos_count }}</span>
                                </td>
                                <td>{{ $c->deleted_at->format('d/m/Y H:i') }}</td>
                                <td class="d-flex justify-content-center gap-2">
                                    <form action="{{ route('clientes.restaurar', $c->id) }}" method="POST" class="form-restaurar">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm">♻️ Restaurar</button>
                                    </form>

                                    <form action="{{ route('clientes.forzar', $c->id) }}" method="POST" class="form-forzar">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-dark btn-sm">🗑 Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted py-4">
                                    No hay clientes en la papelera
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINACIÓN --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $clientes->links() }}
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // SweetAlert2 para restaurar
    document.querySelectorAll('.form-restaurar').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Restaurar cliente?',
                text: 'El cliente volverá a estar activo en el sistema.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, restaurar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // SweetAlert2 para eliminar permanentemente
    document.querySelectorAll('.form-forzar').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Eliminar PERMANENTEMENTE?',
                text: 'Esta acción no se puede deshacer. El cliente se eliminará definitivamente.',
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#212529',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar permanentemente',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush

@endsection

