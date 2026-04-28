@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <a href="{{ route('lavados.index') }}" class="btn btn-secondary me-2">
                        ⬅ Volver
                    </a>
                    <h3 class="mb-0 d-inline">💰 Cobrar Lavado #{{ $lavado->id_orden }}</h3>
                </div>
            </div>

            {{-- RESUMEN DEL LAVADO --}}
            <div class="card shadow-sm border-0 rounded-4 mb-3">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase mb-2">Cliente</h6>
                    <p class="mb-1"><strong>{{ $lavado->cliente->nombre ?? '—' }}</strong></p>
                    <p class="mb-0 text-muted">{{ $lavado->moto->placa ?? '—' }} — {{ $lavado->servicio->nombre ?? '—' }}</p>
                </div>
            </div>

            {{-- RESUMEN DE PAGO --}}
            <div class="card shadow-sm border-0 rounded-4 mb-3">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4 border-end">
                            <small class="text-muted text-uppercase">Precio Total</small>
                            <h5 class="text-primary mb-0">Bs. {{ number_format($lavado->precio_total, 2) }}</h5>
                        </div>
                        <div class="col-4 border-end">
                            <small class="text-muted text-uppercase">Pagado</small>
                            <h5 class="text-success mb-0">Bs. {{ number_format($lavado->monto_pagado, 2) }}</h5>
                        </div>
                        <div class="col-4">
                            <small class="text-muted text-uppercase">Saldo</small>
                            <h5 class="{{ $lavado->saldo > 0 ? 'text-danger' : 'text-success' }} mb-0">
                                Bs. {{ number_format($lavado->saldo, 2) }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            @if($lavado->saldo <= 0)
                <div class="alert alert-success text-center">
                    ✅ Este lavado ya está completamente pagado.
                </div>
            @else
                {{-- FORMULARIO DE COBRO --}}
                <div class="card shadow border-0 rounded-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Registrar Cobro</h5>
                    </div>
                    <div class="card-body">

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('lavados.cobrar', $lavado->id_orden) }}" method="POST" id="form-cobro">
                            @csrf
                            @method('PATCH')

                            {{-- MÉTODO DE PAGO --}}
                            <div class="mb-3">
                                <label class="form-label">Método de pago</label>
                                <select name="metodo_pago" id="metodo_pago" class="form-control" required>
                                    <option value="" disabled {{ old('metodo_pago') ? '' : 'selected' }}>-- Seleccione --</option>
                                    <option value="efectivo" {{ old('metodo_pago') == 'efectivo' ? 'selected' : '' }}>💵 Efectivo</option>
                                    <option value="qr" {{ old('metodo_pago') == 'qr' ? 'selected' : '' }}>📱 QR</option>
                                    <option value="efectivo/qr" {{ old('metodo_pago') == 'efectivo/qr' ? 'selected' : '' }}>💵📱 Efectivo + QR</option>
                                </select>
                            </div>

                            {{-- MONTO ÚNICO (efectivo o QR) --}}
                            <div class="mb-3" id="campo-monto-unico">
                                <label class="form-label">Monto a cobrar (Bs.)</label>
                                <input type="number" step="0.01" min="0.01" max="{{ $lavado->saldo }}"
                                       name="monto_abono" id="monto_unico" value="{{ old('monto_abono', $lavado->saldo) }}"
                                       class="form-control form-control-lg" autofocus>
                                <small class="text-muted">Máximo: Bs. {{ number_format($lavado->saldo, 2) }}</small>
                            </div>

                            {{-- MONTOS SEPARADOS (efectivo + QR) --}}
                            <div class="mb-3 d-none" id="campo-monto-mixto">
                                <label class="form-label">Monto en efectivo (Bs.)</label>
                                <input type="number" step="0.01" min="0" max="{{ $lavado->saldo }}"
                                       name="monto_efectivo" id="monto_efectivo" value="{{ old('monto_efectivo', 0) }}"
                                       class="form-control form-control-lg mb-2">

                                <label class="form-label">Monto en QR (Bs.)</label>
                                <input type="number" step="0.01" min="0" max="{{ $lavado->saldo }}"
                                       name="monto_qr" id="monto_qr" value="{{ old('monto_qr', 0) }}"
                                       class="form-control form-control-lg">
                                <small class="text-muted">La suma no puede superar Bs. {{ number_format($lavado->saldo, 2) }}</small>
                                <div id="error-mixto" class="text-danger small d-none mt-1">⚠️ La suma de efectivo + QR debe ser mayor a 0 y no superar el saldo.</div>
                            </div>

                            <div class="alert alert-light border mb-3">
                                <div class="d-flex justify-content-between">
                                    <span>Saldo actual:</span>
                                    <strong>Bs. {{ number_format($lavado->saldo, 2) }}</strong>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Abono:</span>
                                    <strong id="preview-abono" class="text-success">Bs. 0.00</strong>
                                </div>
                                <hr class="my-1">
                                <div class="d-flex justify-content-between">
                                    <span>Saldo restante:</span>
                                    <strong id="preview-restante" class="text-danger">Bs. {{ number_format($lavado->saldo, 2) }}</strong>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success w-100 btn-lg" id="btn-cobrar">
                                <span class="spinner-border spinner-border-sm d-none" id="spinner"></span>
                                💰 Confirmar Cobro
                            </button>
                        </form>

                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const metodoSelect = document.getElementById('metodo_pago');
        const campoUnico = document.getElementById('campo-monto-unico');
        const campoMixto = document.getElementById('campo-monto-mixto');
        const montoUnico = document.getElementById('monto_unico');
        const montoEfectivo = document.getElementById('monto_efectivo');
        const montoQr = document.getElementById('monto_qr');
        const previewAbono = document.getElementById('preview-abono');
        const previewRestante = document.getElementById('preview-restante');
        const errorMixto = document.getElementById('error-mixto');
        const saldoActual = {{ $lavado->saldo }};
        const form = document.getElementById('form-cobro');
        const btnCobrar = document.getElementById('btn-cobrar');
        const spinner = document.getElementById('spinner');

        function toggleCampos() {
            const metodo = metodoSelect.value;
            if (metodo === 'efectivo/qr') {
                campoUnico.classList.add('d-none');
                campoMixto.classList.remove('d-none');
                montoUnico.removeAttribute('required');
                montoEfectivo.setAttribute('required', 'required');
                montoQr.setAttribute('required', 'required');
            } else {
                campoUnico.classList.remove('d-none');
                campoMixto.classList.add('d-none');
                montoUnico.setAttribute('required', 'required');
                montoEfectivo.removeAttribute('required');
                montoQr.removeAttribute('required');
            }
            actualizarPreview();
        }

        function actualizarPreview() {
            const metodo = metodoSelect.value;
            let abono = 0;

            if (metodo === 'efectivo/qr') {
                const ef = parseFloat(montoEfectivo.value || 0);
                const qr = parseFloat(montoQr.value || 0);
                abono = ef + qr;
            } else {
                abono = parseFloat(montoUnico.value || 0);
            }

            const restante = Math.max(0, saldoActual - abono);
            previewAbono.textContent = 'Bs. ' + abono.toFixed(2);
            previewRestante.textContent = 'Bs. ' + restante.toFixed(2);

            if (restante <= 0) {
                previewRestante.className = 'text-success';
            } else {
                previewRestante.className = 'text-danger';
            }

            // Validación visual mixto
            if (metodo === 'efectivo/qr') {
                if (abono <= 0 || abono > saldoActual) {
                    errorMixto.classList.remove('d-none');
                } else {
                    errorMixto.classList.add('d-none');
                }
            }
        }

        metodoSelect.addEventListener('change', toggleCampos);
        montoUnico.addEventListener('input', actualizarPreview);
        montoEfectivo.addEventListener('input', actualizarPreview);
        montoQr.addEventListener('input', actualizarPreview);

        toggleCampos();

        form.addEventListener('submit', function () {
            btnCobrar.disabled = true;
            spinner.classList.remove('d-none');
        });
    });
</script>
@endpush
@endsection
