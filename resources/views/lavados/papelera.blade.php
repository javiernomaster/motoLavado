@extends('layouts.app')

@section('content')

<style>
/* HEADER JM */
.jm-header {
    background: linear-gradient(135deg, #071a38 0%, #0b2f5b 45%, #114c8d 100%);
    color: #fff;
    padding: 22px 32px;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(7,26,56,.30);
    margin-bottom: 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.jm-header-left {
    display: flex;
    align-items: center;
    gap: 16px;
}

.jm-header-title {
    font-size: 20px;
    font-weight: 800;
}

.jm-header-subtitle {
    font-size: 13px;
    opacity: .8;
}

.jm-header-module {
    background: rgba(255,255,255,.15);
    padding: 5px 14px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 600;
}

.jm-date {
    font-size: 13px;
    opacity: .85;
}
</style>

<div class="container mt-4">

    {{-- HEADER JM --}}
    <div class="jm-header">

        <div class="jm-header-left">
            <img src="{{ asset('images/logoM.png') }}"
                 style="width:60px;height:60px;object-fit:contain;">
            <div>
                <div class="jm-header-title">SISTEMA JM</div>
                <div class="jm-header-subtitle">Panel de control</div>
            </div>
        </div>

        <div style="text-align:right;">
            <div class="jm-header-module">
                🗑 Papelera de Lavados
            </div>
            <div class="jm-date">
                {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM YYYY') }}
            </div>
        </div>

    </div>

    {{-- BOTONES --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h4 class="fw-bold" style="color:#0b2f5b;">
            <i class="bi bi-trash3 me-2"></i> Lavados eliminados
        </h4>

        <a href="{{ route('lavados.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>

    </div>

    {{-- ALERTA --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- CARD TABLA --}}
    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-header text-white"
             style="background:linear-gradient(135deg,#0b2f5b,#114c8d);">
            <h5 class="mb-0">🗂 Registros eliminados</h5>
        </div>

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

                            <td class="text-center d-flex justify-content-center gap-2">

                                {{-- RESTAURAR --}}
                                <form action="{{ route('lavados.restaurar', $lavado->id_orden) }}"
                                      method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-success btn-sm fw-bold">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                </form>

                                {{-- ELIMINAR --}}
                                <form action="{{ route('lavados.forzar', $lavado->id_orden) }}"
                                      method="POST" class="form-forzar">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm fw-bold">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>

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

{{-- SWEETALERT --}}
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