@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="bi bi-droplet-fill me-2"></i>
            <h5 class="mb-0">Registrar Nuevo Lavado</h5>
        </div>

        <div class="card-body">

            <form action="{{ route('lavados.store') }}" method="POST">
                @csrf

                <!-- Fecha -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-calendar-date me-1"></i> Fecha
                    </label>
                    <input type="date" name="fecha" class="form-control form-control-lg" required>
                </div>

                <!-- Cliente -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-person-fill me-1"></i> Cliente
                    </label>
                    <select name="id_cliente" class="form-select form-select-lg" required>
                        <option selected disabled>Seleccione un cliente</option>
                        @foreach($clientes as $c)
                            <option value="{{ $c->id_cliente }}">{{ $c->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Moto -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-bicycle me-1"></i> Moto
                    </label>
                    <select name="placa" class="form-select form-select-lg" required>
                        <option selected disabled>Seleccione una moto</option>
                        @foreach($motos as $m)
                            <option value="{{ $m->placa }}">{{ $m->placa }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Botón -->
                <div class="d-flex justify-content-end">
                    <button class="btn btn-success btn-lg px-4">
                        <i class="bi bi-save me-1"></i> Guardar Lavado
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection