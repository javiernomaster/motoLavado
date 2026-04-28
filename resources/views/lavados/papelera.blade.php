@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('lavados.index') }}" class="btn btn-secondary me-2">
                ⬅ Volver a Lavados
            </a>
            <h3 class="mb-0 d-inline">🗑️ Papelera de Lavados</h3>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-hover align-middle text-center">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Placa</th>
                            <th>Servicio</th>
                            <th>Trabajador</th>
                            <th>Estado</th>
                            <th>Total</th>
                            <th>Eliminado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($lavados as $l)
                            <tr>
                                <td>{{ $l->id_orden }}</td>
                                <td>{{ \Carbon\Carbon::parse($l->fecha)->format('d/m/Y') }}</td>
                                <td>{{ $l->cliente->nombre ?? '—' }}</td>
                                <td>{{ $l->moto->placa ?? '—' }}</td>
                                <td>{{ $l->servicio->nombre ?? '—' }}</td>
                                <td>{{ $l->trabajador->nombre ?? '—' }}</td>
                                <td>{{ $l->estado }}</td>
                                <td><strong>Bs. {{ number_format($l->precio_total, 2) }}</strong></td>
                                <td>{{ $l->deleted_at->diffForHumans() }}</td>
                                <td>
                                    <form action="{{ route('lavados.restaurar', $l->id_orden) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" class="btn btn-success btn-sm btn-restaurar">Restaurar</button>
                                    </form>
                                    <form action="{{ route('lavados.forzar', $l->id_orden) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-forzar">Eliminar definitivamente</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-muted py-4">
                                    No hay lavados eliminados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $lavados->links() }}
            </div>

        </div>
    </div>

</div>

@push('scripts')
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#0d6efd',
            timer: 3000,
            timerProgressBar: true
        });
    @endif

    document.querySelectorAll('.btn-restaurar').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');

            Swal.fire({
                title: '¿Restaurar lavado?',
                text: 'El lavado volverá a estar activo.',
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

    document.querySelectorAll('.btn-forzar').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');

            Swal.fire({
                title: '¿Eliminar permanentemente?',
                text: '¡Esta acción no se puede deshacer!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar definitivamente',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush

@endsection

