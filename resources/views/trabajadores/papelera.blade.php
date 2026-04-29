@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('trabajadores.index') }}" class="btn btn-secondary me-2">
                ⬅ Volver
            </a>
            <h3 class="mb-0 d-inline">🗑 Papelera Trabajadores</h3>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>CI</th>
                            <th>Lavados</th>
                            <th>Eliminado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trabajadores as $t)
                            <tr>
                                <td>{{ $t->id }}</td>
                                <td class="fw-semibold">{{ $t->nombre }}</td>
                                <td>{{ $t->ci }}</td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $t->lavados_count }}
                                    </span>
                                </td>
                                <td>{{ $t->deleted_at->format('d/m/Y H:i') }}</td>
                                <td class="d-flex justify-content-center gap-2">

                                    {{-- RESTAURAR --}}
                                    <form action="{{ route('trabajadores.restaurar', $t->id) }}" method="POST" class="form-restaurar">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm">♻️ Restaurar</button>
                                    </form>

                                    {{-- FORZAR ELIMINAR --}}
                                    <form action="{{ route('trabajadores.forzar', $t->id) }}" method="POST" class="form-forzar">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-dark btn-sm">🗑 Eliminar Perm.</button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-muted py-4">
                                    No hay trabajadores en papelera
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $trabajadores->withQueryString()->links() }}
            </div>
        </div>
    </div>

</div>

<script>
document.querySelectorAll('.form-restaurar').forEach(form => {
    form.addEventListener('submit', e => {
        e.preventDefault();
        Swal.fire({
            title: '¿Restaurar?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, restaurar'
        }).then(r => r.isConfirmed && form.submit());
    });
});

document.querySelectorAll('.form-forzar').forEach(form => {
    form.addEventListener('submit', e => {
        e.preventDefault();
        Swal.fire({
            title: '¿Eliminar PERMANENTEMENTE?',
            text: 'No se puede recuperar.',
            icon: 'error',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar'
        }).then(r => r.isConfirmed && form.submit());
    });
});
</script>

@endsection