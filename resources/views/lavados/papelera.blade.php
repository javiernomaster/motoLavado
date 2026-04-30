@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold" style="color:#0b2f5b;">
            <i class="bi bi-trash3 me-2"></i> Papelera de Lavados
        </h4>
        <a href="{{ route('lavados.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Moto</th>
                            <th>Servicio</th>
                            <th>Trabajador</th>
                            <th>Total</th>
                            <th>Eliminado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($lavados as $lavado)
                        <tr>
                            <td>{{ $lavado->id_orden }}</td>
                            <td>{{ \Carbon\Carbon::parse($lavado->fecha)->format('d/m/Y') }}</td>
                            <td>{{ $lavado->cliente->nombre ?? '—' }}</td>
                            <td>{{ $lavado->moto->placa ?? '—' }}</td>
                            <td>{{ $lavado->servicio->nombre ?? '—' }}</td>
                            <td>{{ $lavado->trabajador->nombre ?? '—' }}</td>
                            <td>Bs. {{ number_format($lavado->precio_total, 2) }}</td>
                            <td>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($lavado->deleted_at)->format('d/m/Y H:i') }}
                                </small>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">

                                    {{-- Restaurar --}}
                                    <form action="{{ route('lavados.restaurar', $lavado->id_orden) }}"
                                          method="POST" class="m-0">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="btn btn-sm btn-success fw-bold">
                                            <i class="bi bi-arrow-counterclockwise"></i> Restaurar
                                        </button>
                                    </form>

                                    {{-- Eliminar permanente --}}
                                    <form action="{{ route('lavados.forzar', $lavado->id_orden) }}"
                                          method="POST" class="form-forzar m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-danger fw-bold">
                                            <i class="bi bi-trash-fill"></i> Eliminar
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                                La papelera está vacía
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($lavados->hasPages())
                <div class="p-3 d-flex justify-content-center">
                    {{ $lavados->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.form-forzar').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Eliminar permanentemente?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    });
});
</script>

@endsection