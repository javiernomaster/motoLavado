@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow border-0">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">Editar Lavado #{{ $lavado->id_orden }}</h4>
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

            <form action="{{ route('lavados.update', $lavado->id_orden) }}" method="POST" id="form-editar">
                @csrf
                @method('PUT')

                <!-- FECHA -->
                <div class="mb-3">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="fecha" value="{{ old('fecha', $lavado->fecha->format('Y-m-d')) }}" class="form-control" required>
                </div>

                <!-- CLIENTE -->
                <div class="mb-3">
                    <label class="form-label">Cliente</label>
                    <select name="cliente_id" id="cliente_id" class="form-control" required>
                        @foreach($clientes as $c)
                            <option value="{{ $c->id }}" {{ old('cliente_id', $lavado->cliente_id) == $c->id ? 'selected' : '' }}>
                                {{ $c->nombre }} (CI: {{ $c->ci }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- MOTO -->
                <div class="mb-3">
                    <label class="form-label">Moto</label>
                    <select name="moto_id" id="moto_id" class="form-control" required>
                        @foreach($motos as $m)
                            <option value="{{ $m->id }}" data-cliente="{{ $m->cliente_id }}" {{ old('moto_id', $lavado->moto_id) == $m->id ? 'selected' : '' }}>
                                {{ $m->placa }} - {{ $m->marca }} {{ $m->modelo }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Solo se muestran las motos del cliente seleccionado.</small>
                </div>

                <!-- SERVICIO -->
                <div class="mb-3">
                    <label class="form-label">Servicio</label>
                    <select name="servicio_id" id="servicio_id" class="form-control" required>
                        @foreach($servicios as $s)
                            <option value="{{ $s->id }}" data-precio="{{ $s->precio }}" {{ old('servicio_id', $lavado->servicio_id) == $s->id ? 'selected' : '' }}>
                                {{ $s->nombre }} - Bs {{ number_format($s->precio, 2) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- PRECIO TOTAL -->
                <div class="mb-3">
                    <label class="form-label">Precio total del servicio</label>
                    <input type="number" step="0.01" id="precio_total" value="{{ old('precio_total', $lavado->precio_total) }}" class="form-control" readonly>
                    <small class="text-muted">Se recalcula automáticamente si cambias de servicio.</small>
                </div>

                <!-- TRABAJADOR -->
                <div class="mb-3">
                    <label class="form-label">Trabajador</label>
                    <select name="trabajador_id" class="form-control" required>
                        @foreach($trabajadores as $t)
                            <option value="{{ $t->id }}" {{ old('trabajador_id', $lavado->trabajador_id) == $t->id ? 'selected' : '' }}>
                                {{ $t->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- ESTADO (máquina de estados) -->
                <div class="mb-3">
                    <label class="form-label">Estado actual: <span class="badge bg-secondary">{{ $lavado->estado }}</span></label>
                    <select name="estado" class="form-control" required>
                        <option value="{{ $lavado->estado }}" selected>
                            Mantener: {{ $lavado->estado }}
                        </option>
                        @foreach($transiciones as $transicion)
                            <option value="{{ $transicion }}">
                                Cambiar a: {{ $transicion }}
                            </option>
                        @endforeach
                    </select>
                    @if(empty($transiciones) && $lavado->estado !== 'Finalizado')
                        <small class="text-muted">No hay transiciones disponibles desde este estado.</small>
                    @endif
                    @if($lavado->estado === 'Finalizado')
                        <div class="alert alert-warning mt-2 py-1">
                            <small>⚠️ El lavado está finalizado. No se permiten más cambios de estado.</small>
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary" id="btn-actualizar">
                    <span class="spinner-border spinner-border-sm d-none" id="spinner"></span>
                    Actualizar
                </button>
                <a href="{{ route('lavados.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>

        </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const clienteSelect = document.getElementById('cliente_id');
        const motoSelect = document.getElementById('moto_id');
        const servicioSelect = document.getElementById('servicio_id');
        const precioTotalInput = document.getElementById('precio_total');
        const form = document.getElementById('form-editar');
        const btnActualizar = document.getElementById('btn-actualizar');
        const spinner = document.getElementById('spinner');

        let precioActual = parseFloat(precioTotalInput.value || 0);

        // ── Cascade: filtrar motos por cliente ──
        function filtrarMotos() {
            const clienteId = clienteSelect.value;
            const opciones = motoSelect.querySelectorAll('option[data-cliente]');

            opciones.forEach(opt => {
                if (opt.dataset.cliente === clienteId) {
                    opt.style.display = 'block';
                } else {
                    opt.style.display = 'none';
                    if (opt.selected) opt.selected = false;
                }
            });
        }

        clienteSelect.addEventListener('change', filtrarMotos);
        filtrarMotos();

        // ── Recalcular precio si cambia el servicio ──
        function recalcularPrecio() {
            const selected = servicioSelect.options[servicioSelect.selectedIndex];
            const precioServicio = parseFloat(selected.dataset.precio || 0);

            if (servicioSelect.value != {{ $lavado->servicio_id }}) {
                precioActual = precioServicio;
                precioTotalInput.value = precioActual.toFixed(2);
            }
        }

        servicioSelect.addEventListener('change', recalcularPrecio);

        // ── Deshabilitar botón al enviar ──
        form.addEventListener('submit', function () {
            btnActualizar.disabled = true;
            spinner.classList.remove('d-none');
        });
    });
</script>
@endpush

@endsection
