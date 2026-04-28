@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary me-2">
                ⬅ Volver al inicio
            </a>
            <h3 class="mb-0 d-inline">🚿 Lista de Lavados</h3>
        </div>
        <div>
            <a href="{{ route('lavados.papelera') }}" class="btn btn-outline-dark me-2">
                🗑️ Papelera
            </a>
            <a href="{{ route('lavados.create') }}" class="btn btn-primary">
                ➕ Nuevo Lavado
            </a>
        </div>
    </div>

    {{-- FILTROS --}}
    <form method="GET" action="{{ route('lavados.index') }}" class="row g-3 mb-3">

        <div class="col-md-3">
            <input type="text" name="cliente" value="{{ request('cliente') }}" class="form-control" placeholder="Cliente">
        </div>

        <div class="col-md-2">
            <select name="estado" class="form-control">
                <option value="">Estado</option>
                <option value="Pendiente" {{ request('estado')=='Pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="En proceso" {{ request('estado')=='En proceso' ? 'selected' : '' }}>En proceso</option>
                <option value="Finalizado" {{ request('estado')=='Finalizado' ? 'selected' : '' }}>Finalizado</option>
            </select>
        </div>

        <div class="col-md-2">
            <input type="date" name="desde" value="{{ request('desde') }}" class="form-control">
        </div>

        <div class="col-md-2">
            <input type="date" name="hasta" value="{{ request('hasta') }}" class="form-control">
        </div>

        <div class="col-md-3">
            <button class="btn btn-dark w-100">Filtrar</button>
        </div>

    </form>

    {{-- TOTALES --}}
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="alert alert-info mb-0 py-2">
                <strong>Precio total filtrado:</strong> Bs. {{ number_format($totalFiltrado ?? 0, 2) }}
                <span class="mx-2">|</span>
                <strong>Total pagado:</strong> Bs. {{ number_format($totalPagado ?? 0, 2) }}
                <span class="mx-2">|</span>
                <strong>Cantidad:</strong> {{ $cantidadFiltrada ?? 0 }} lavados
            </div>
        </div>
    </div>

    {{-- TABLA --}}
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
                            <th>Total</th>
                            <th>Pagado</th>
                            <th>Saldo</th>
                            <th>Pago</th>
                            <th>Estado</th>
                            <th style="min-width: 280px;">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($lavados as $l)
                            @php
                                $rowClass = match($l->estado) {
                                    'Pendiente' => 'table-warning',
                                    'En proceso' => 'table-info',
                                    'Finalizado' => 'table-success',
                                    default => '',
                                };
                                $pagoBadgeClass = match($l->estado_pago) {
                                    'pagado' => 'bg-success',
                                    'parcial' => 'bg-warning text-dark',
                                    default => 'bg-danger',
                                };
                                $pagoText = match($l->estado_pago) {
                                    'pagado' => '💵 Pagado',
                                    'parcial' => '💵 Parcial',
                                    default => '❌ Pendiente',
                                };
                                $metodoIcon = match($l->metodo_pago) {
                                    'efectivo' => '💵',
                                    'qr' => '📱',
                                    'efectivo/qr' => '💵📱',
                                    default => '',
                                };
                            @endphp
                            <tr class="{{ $rowClass }}">
                                <td>{{ $l->id_orden }}</td>
                                <td>{{ \Carbon\Carbon::parse($l->fecha)->format('d/m/Y') }}</td>
                                <td>{{ $l->cliente->nombre ?? '—' }}</td>
                                <td>{{ $l->moto->placa ?? '—' }}</td>
                                <td>{{ $l->servicio->nombre ?? '—' }}</td>
                                <td><strong>Bs. {{ number_format($l->precio_total, 2) }}</strong></td>
                                <td>Bs. {{ number_format($l->monto_pagado, 2) }}</td>
                                <td class="{{ $l->saldo > 0 ? 'text-danger fw-bold' : 'text-success' }}">
                                    Bs. {{ number_format($l->saldo, 2) }}
                                    <br>
                                    <span class="badge {{ $pagoBadgeClass }}" style="font-size: 0.7em;">
                                        {{ $pagoText }}
                                    </span>
                                </td>
                                <td>
                                    @if($l->metodo_pago)
                                        <span class="badge bg-secondary">{{ $metodoIcon }} {{ ucfirst(str_replace('/', ' + ', $l->metodo_pago)) }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $estadoBadgeClass = match($l->estado) {
                                            'Pendiente' => 'bg-warning text-dark',
                                            'En proceso' => 'bg-info text-dark',
                                            'Finalizado' => 'bg-success',
                                            default => 'bg-secondary',
                                        };
                                        $estadoText = match($l->estado) {
                                            'Pendiente' => '⏳ Pendiente',
                                            'En proceso' => '🔧 En proceso',
                                            'Finalizado' => '✅ Finalizado',
                                            default => $l->estado,
                                        };
                                    @endphp
                                    <span class="badge {{ $estadoBadgeClass }}">
                                        {{ $estadoText }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('lavados.show', $l->id_orden) }}" class="btn btn-info btn-sm mb-1">Ver</a>
                                    <a href="{{ route('lavados.edit', $l->id_orden) }}" class="btn btn-warning btn-sm mb-1">Editar</a>
                                    @if($l->estado_pago !== 'pagado')
                                        <a href="{{ route('lavados.cobrar.form', $l->id_orden) }}" class="btn btn-success btn-sm mb-1">💰 Cobrar</a>
                                    @endif
                                    <a href="{{ route('lavados.historial', $l->id_orden) }}" class="btn btn-secondary btn-sm mb-1">Historial</a>

                                    @if($l->estado !== 'Finalizado')
                                        <form action="{{ route('lavados.estado', $l->id_orden) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="estado"
                                                value="{{ $l->estado === 'Pendiente' ? 'En proceso' : 'Finalizado' }}">
                                            <button type="button"
                                                class="btn btn-outline-primary btn-sm mb-1 btn-cambiar-estado"
                                                data-mensaje="¿Marcar como {{ $l->estado === 'Pendiente' ? 'En proceso' : 'Finalizado' }}?">
                                                {{ $l->estado === 'Pendiente' ? '▶ En proceso' : '✅ Finalizar' }}
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('lavados.destroy', $l->id_orden) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm mb-1 btn-eliminar">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-muted py-4">
                                    No hay lavados registrados
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

    document.querySelectorAll('.btn-eliminar').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');

            Swal.fire({
                title: '¿Eliminar lavado?',
                text: 'El lavado se moverá a la papelera.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    document.querySelectorAll('.btn-cambiar-estado').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');
            const mensaje = this.dataset.mensaje;

            Swal.fire({
                title: mensaje,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, confirmar',
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
