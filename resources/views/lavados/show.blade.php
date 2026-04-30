@extends('layouts.app')

@section('content')

<style>
/* HEADER JM (igual al módulo motos) */
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
}

.jm-date {
    font-size: 13px;
    opacity: .85;
    margin-top: 5px;
}
</style>

<div class="container mt-4">

    {{-- HEADER SISTEMA JM --}}
    <div class="jm-header">
        <div class="jm-header-left">
            <img src="{{ asset('images/logoM.png') }}"
                 style="width:60px;height:60px;object-fit:contain;">
            <div>
                <div class="jm-header-title">SISTEMA JM</div>
                <div class="jm-header-subtitle">Panel de control</div>
            </div>
        </div>

        <div>
            <div class="jm-header-module">
                🛵 Módulo Lavados
            </div>
            <div class="jm-date">
                {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM YYYY') }}
            </div>
        </div>
    </div>

    {{-- BOTONES --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('lavados.index') }}" class="btn btn-secondary me-2">
                ⬅ Volver
            </a>
            <h3 class="mb-0 d-inline fw-bold" style="color:#0b2f5b;">
                Detalle del Lavado {{ $lavado->id_orden }}
            </h3>
        </div>

        <div>
            @if($lavado->estado_pago !== 'pagado')
                <a href="{{ route('lavados.cobrar.form', $lavado->id_orden) }}" class="btn btn-success">
                    💰 Cobrar
                </a>
            @endif
            <a href="{{ route('lavados.historial', $lavado->id_orden) }}" class="btn btn-outline-secondary">
                📋 Historial
            </a>
            <a href="{{ route('lavados.edit', $lavado->id_orden) }}" class="btn btn-warning">
                ✏ Editar
            </a>
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

    {{-- CARD PRINCIPAL --}}
    <div class="card p-4 {{ $estadoClass }} border-2 shadow-sm rounded-4">

        <div class="row">
            <div class="col-md-6">
                <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($lavado->fecha)->format('d/m/Y') }}</p>
                <p><strong>Cliente:</strong> {{ $lavado->cliente->nombre ?? '—' }}</p>
                <p><strong>Teléfono:</strong> {{ $lavado->cliente->telefono ?? '—' }}</p>
                <p><strong>Placa:</strong> {{ $lavado->moto->placa ?? '—' }}</p>
                <p><strong>Moto:</strong> {{ $lavado->moto->marca ?? '' }} {{ $lavado->moto->modelo ?? '' }}</p>
            </div>

            <div class="col-md-6">
                <p><strong>Servicio:</strong> {{ $lavado->servicio->nombre ?? '—' }}</p>
                <p><strong>Trabajador:</strong> {{ $lavado->trabajador->nombre ?? '—' }}</p>
                <p>
                    <strong>Estado:</strong>
                    <span class="badge {{ $estadoBadge }}">{{ $lavado->estado }}</span>
                </p>
            </div>
        </div>

        {{-- PAGO --}}
        <div class="row mt-3">

            <div class="col-12 mb-2">
                <h5 class="fw-bold" style="color:#0b2f5b;">💰 Información de Pago</h5>
            </div>

            <div class="col-md-3">
                <div class="card text-center p-3 bg-light rounded-4">
                    <small class="text-muted">Total</small>
                    <h4 class="text-primary">Bs. {{ number_format($lavado->precio_total, 2) }}</h4>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center p-3 bg-light rounded-4">
                    <small class="text-muted">Pagado</small>
                    <h4 class="text-success">Bs. {{ number_format($lavado->monto_pagado, 2) }}</h4>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center p-3 bg-light rounded-4">
                    <small class="text-muted">Saldo</small>
                    <h4 class="text-danger">Bs. {{ number_format($lavado->saldo, 2) }}</h4>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center p-3 bg-light rounded-4">
                    <small class="text-muted">Estado Pago</small>
                    <h4>
                        <span class="badge {{ $pagoBadgeClass }}">
                            {{ ucfirst($lavado->estado_pago) }}
                        </span>
                    </h4>
                </div>
            </div>

        </div>

        <hr>

        {{-- HISTORIAL --}}
        <h6 class="fw-bold mb-3">📋 Últimos cambios</h6>

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
                            <td>{{ $h->observacion ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Sin historial</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection