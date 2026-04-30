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
                🚗 Módulo Lavados
            </div>
            <div class="jm-date">
                {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM YYYY') }}
            </div>
        </div>

    </div>

    {{-- CARD FORMULARIO --}}
    <div class="card shadow border-0 rounded-4">

        <div class="card-header text-white text-center"
             style="background:linear-gradient(135deg,#0b2f5b,#114c8d);">
            <h4 class="mb-0">➕ Registrar Nuevo Lavado</h4>
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

            <form action="{{ route('lavados.store') }}" method="POST" id="form-lavado">
                @csrf

                {{-- FECHA --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Fecha</label>
                    <input type="date" name="fecha"
                           value="{{ old('fecha', \Carbon\Carbon::today()->format('Y-m-d')) }}"
                           class="form-control" required>
                </div>

                {{-- CLIENTE --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Cliente</label>
                    <select name="cliente_id" id="cliente_id" class="form-control" required>
                        <option value="">Seleccione cliente</option>
                        @foreach($clientes as $c)
                            <option value="{{ $c->id }}"
                                {{ ($clientePreseleccionado == $c->id || old('cliente_id') == $c->id) ? 'selected' : '' }}>
                                {{ $c->nombre }} (CI: {{ $c->ci }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- MOTO --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Moto</label>
                    <select name="moto_id" id="moto_id" class="form-control" required>
                        <option value="">Seleccione moto</option>
                        @foreach($motos as $m)
                            <option value="{{ $m->id }}"
                                    data-cliente="{{ $m->cliente_id }}"
                                    {{ old('moto_id') == $m->id ? 'selected' : '' }}>
                                {{ $m->placa }} - {{ $m->marca }} {{ $m->modelo }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Solo motos del cliente seleccionado</small>
                </div>

                {{-- SERVICIO --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Servicio</label>
                    <select name="servicio_id" id="servicio_id" class="form-control" required>
                        <option value="">Seleccione servicio</option>
                        @foreach($servicios as $s)
                            <option value="{{ $s->id }}"
                                    data-precio="{{ $s->precio }}"
                                    {{ old('servicio_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->nombre }} - Bs {{ number_format($s->precio,2) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- PRECIO --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Precio total</label>
                    <input type="text" id="precio-total-preview"
                           class="form-control" readonly value="Bs. 0.00">
                </div>

                {{-- TRABAJADOR --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Trabajador</label>
                    <select name="trabajador_id" class="form-control" required>
                        <option value="">Seleccione trabajador</option>
                        @foreach($trabajadores as $t)
                            <option value="{{ $t->id }}">
                                {{ $t->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- BOTONES --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success" id="btn-guardar">
                        Guardar Lavado
                    </button>
                    <a href="{{ route('lavados.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

{{-- SCRIPT ORIGINAL (NO TOCAR LÓGICA) --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const clienteSelect = document.getElementById('cliente_id');
    const motoSelect = document.getElementById('moto_id');
    const servicioSelect = document.getElementById('servicio_id');
    const precioTotalPreview = document.getElementById('precio-total-preview');

    function filtrarMotos() {
        const clienteId = clienteSelect.value;

        Array.from(motoSelect.options).forEach(opt => {
            if (!opt.dataset.cliente) return;
            opt.style.display = opt.dataset.cliente === clienteId ? 'block' : 'none';
        });

        motoSelect.value = '';
    }

    clienteSelect.addEventListener('change', filtrarMotos);

    servicioSelect.addEventListener('change', function () {
        const precio = this.options[this.selectedIndex].dataset.precio || 0;
        precioTotalPreview.value = 'Bs. ' + parseFloat(precio).toFixed(2);
    });

});
</script>

@endsection