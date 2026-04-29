@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('motos.index') }}" class="btn btn-secondary me-2">
                ⬅ Volver
            </a>
            <h3 class="mb-0 d-inline">🗑 Papelera Motos</h3>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Placa</th>
                            <th>Marca</th>
                            <th>Lavados</th>
                            <th>Eliminado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($motos as $m)
                            <tr>
                                <td class="fw-semibold">{{ $m->placa }}</td>
                                <td>{{ $m->marca }}</td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $m->lavados_count }}
                                    </span>
                                </td>
                                <td>{{ $m->deleted_at->format('d/m/Y H:i') }}</td>
                                <td class="d-flex justify-content-center gap-2">

                                    {{-- ✅ AQUÍ ESTABA EL ERROR --}}
                                    <form action="{{ route('motos.restaurar', $m->id) }}" method="POST" class="form-restaurar">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm">♻️ Restaurar</button>
                                    </form>

                                    <form action="{{ route('motos.forzar', $m->id) }}" method="POST" class="form-forzar">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-dark btn-sm">🗑 Eliminar Perm.</button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-muted py-4">
                                    No hay motos en papelera
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $motos->links() }}
            </div>
        </div>
    </div>

</div>
@endsection