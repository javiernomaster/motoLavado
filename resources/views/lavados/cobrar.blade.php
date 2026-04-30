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
                💰 Módulo Cobros
            </div>
            <div class="jm-date">
                {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM YYYY') }}
            </div>
        </div>
    </div>

    {{-- CONTENIDO --}}
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <a href="{{ route('lavados.index') }}" class="btn btn-secondary me-2">
                        ⬅ Volver
                    </a>
                    <h3 class="mb-0 d-inline fw-bold" style="color:#0b2f5b;">
                        💰 Cobrar Lavado #{{ $lavado->id_orden }}
                    </h3>
                </div>
            </div>

            {{-- RESUMEN CLIENTE --}}
            <div class="card shadow-sm border-0 rounded-4 mb-3">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase">Cliente</h6>
                    <p class="mb-1 fw-bold">{{ $lavado->cliente->nombre ?? '—' }}</p>
                    <p class="mb-0 text-muted">
                        {{ $lavado->moto->placa ?? '—' }} — {{ $lavado->servicio->nombre ?? '—' }}
                    </p>
                </div>
            </div>

            {{-- RESUMEN PAGO --}}
            <div class="card shadow-sm border-0 rounded-4 mb-3">
                <div class="card-body text-center">
                    <div class="row">

                        <div class="col-4 border-end">
                            <small class="text-muted">Total</small>
                            <h5 class="text-primary">Bs. {{ number_format($lavado->precio_total, 2) }}</h5>
                        </div>

                        <div class="col-4 border-end">
                            <small class="text-muted">Pagado</small>
                            <h5 class="text-success">Bs. {{ number_format($lavado->monto_pagado, 2) }}</h5>
                        </div>

                        <div class="col-4">
                            <small class="text-muted">Saldo</small>
                            <h5 class="text-danger">Bs. {{ number_format($lavado->saldo, 2) }}</h5>
                        </div>

                    </div>
                </div>
            </div>

            @if($lavado->saldo <= 0)
                <div class="alert alert-success text-center rounded-4">
                    ✅ Este lavado ya está completamente pagado.
                </div>
            @else

            {{-- FORMULARIO --}}
            <div class="card shadow border-0 rounded-4">
                <div class="card-header text-white"
                     style="background:linear-gradient(135deg,#0b2f5b,#114c8d);">
                    <h5 class="mb-0">Registrar Cobro</h5>
                </div>

                <div class="card-body">

                    <form action="{{ route('lavados.cobrar', $lavado->id_orden) }}" method="POST" id="form-cobro">
                        @csrf
                        @method('PATCH')

                        {{-- MÉTODO --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Método de pago</label>
                            <select name="metodo_pago" id="metodo_pago" class="form-control" required>
                                <option value="">Seleccione</option>
                                <option value="efectivo">💵 Efectivo</option>
                                <option value="qr">📱 QR</option>
                                <option value="efectivo/qr">💵📱 Efectivo + QR</option>
                            </select>
                        </div>

                        {{-- MONTO UNICO --}}
                        <div class="mb-3" id="campo-unico">
                            <label class="form-label">Monto</label>
                            <input type="number" step="0.01" name="monto_abono"
                                   class="form-control form-control-lg"
                                   value="{{ $lavado->saldo }}">
                        </div>

                        {{-- BOTÓN --}}
                        <button type="submit" class="btn btn-success w-100 btn-lg">
                            💰 Confirmar Cobro
                        </button>

                    </form>

                </div>
            </div>

            @endif

        </div>
    </div>
</div>

@endsection