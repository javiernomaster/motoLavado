@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('lavados.index') }}" class="btn btn-secondary me-2">
                ⬅ Volver
            </a>
            <h3 class="mb-0 d-inline">Detalle del Lavado #{{ $lavado->id_orden }}</h3>
        </div>
        <div>
            @if($lavado->estado_pago !== 'pagado')
                <a href="{{ route('lavados.cobrar.form', $lavado->id_orden) }}" class="btn btn-success">💰 Cobrar</a>
            @endif
            <a href="{{ route('lavados.historial', $lavado->id_orden) }}" class="btn btn-outline-secondary">📋 Ver Historial</a>
            <a href="{{ route('lavados.edit', $lavado->id_orden) }}" class="btn btn-warning">Editar</a>
        </div>
    </div>

    @php
        $estadoClass = match($lavado->estado) {
            'Pendiente' => 'border-warning',
            'En proceso' => 'border-info',
            'Finalizado' => 'border-success',
            default => '',
        };
        $estadoBadge = match($lavado->estado) {
            'Pendiente' => 'bg-warning text-dark',
            'En proceso' => 'bg-info text-dark',
            'Finalizado' => 'bg-success',
            default => 'bg-secondary',
        };
        $pagoBadgeClass = match($lavado->estado_pago) {
            'pagado' => 'bg-success',
            'parcial' => 'bg-warning text-dark',
            default => 'bg-danger',
        };
    @endphp

    <div class="card p-4 {{ $estadoClass }} border-2">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($lavado->fecha)->format('d/m/Y') }}</p>
                <p><strong>Cliente:</strong> {{ $lavado->cliente->nombre ?? '—' }}</p>
                <p><strong>Teléfono:</strong> {{ $lavado->cliente->telefono ?? '—' }}</p>
                <p><strong>Placa:</strong> {{ $lavado->moto->placa ?? '—' }}</p>
                <p><strong>Marca/Modelo:</strong> {{ $lavado->moto->marca ?? '' }} {{ $lavado->moto->modelo ?? '' }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Servicio:</strong> {{ $lavado->servicio->nombre ?? '—' }}</p>
                <p><strong>Trabajador:</strong> {{ $lavado->trabajador->nombre ?? '—' }}</p>
                <p><strong>Estado:</strong> <span class="badge {{ $estadoBadge }}">{{ $lavado->estado }}</span></p>
            </div>
        </div>

        {{-- SECCIÓN DE PAGO --}}
        <div class="row mt-3">
            <div class="col-12">
                <h5 class="border-bottom pb-2 mb-3">💰 Información de Pago</h5>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-3 bg-light">
                    <small class="text-muted text-uppercase">Precio Total</small>
                    <h4 class="text-primary mb-0">Bs. {{ number_format($lavado->precio_total, 2) }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-3 bg-light">
                    <small class="text-muted text-uppercase">Monto Pagado</small>
                    <h4 class="text-success mb-0">Bs. {{ number_format($lavado->monto_pagado, 2) }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-3 bg-light">
                    <small class="text-muted text-uppercase">Saldo Pendiente</small>
                    <h4 class="{{ $lavado->saldo > 0 ? 'text-danger' : 'text-success' }} mb-0">
                        Bs. {{ number_format($lavado->saldo, 2) }}
                    </h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-3 bg-light">
                    <small class="text-muted text-uppercase">Estado de Pago</small>
                    <h4 class="mb-0"><span class="badge {{ $pagoBadgeClass }}">{{ ucfirst($lavado->estado_pago) }}</span></h4>
                </div>
            </div>
        </div>

        @if($lavado->metodo_pago)
        <div class="row mt-3">
            <div class="col-md-12">
                <p><strong>Método de pago:</strong>
                    @php
                        $metodoIcon = match($lavado->metodo_pago) {
                            'efectivo' => '💵',
                            'qr' => '📱',
                            'efectivo/qr' => '💵📱',
                            default => '',
                        };
                    @endphp
                    <span class="badge bg-secondary fs-6">{{ $metodoIcon }} {{ ucfirst(str_replace('/', ' + ', $lavado->metodo_pago)) }}</span>
                </p>
            </div>
        </div>
        @endif

        <hr>

        {{-- Historial reciente --}}
        <h6 class="mb-3">Últimos cambios de estado</h6>
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Cambio</th>
                        <th>Observación</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lavado->historial->take(5) as $h)
                        <tr>
                            <td>{{ $h->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $h->user->name ?? 'Sistema' }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $h->estado_anterior ?? '—' }}</span>
                                →
                                <span class="badge bg-primary">{{ $h->estado_nuevo }}</span>
                            </td>
                            <td class="text-muted">{{ $h->observacion ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-muted text-center">Sin movimientos registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <a href="{{ route('lavados.index') }}" class="btn btn-secondary">Volver al listado</a>
        </div>
    </div>
</div>
@endsection

