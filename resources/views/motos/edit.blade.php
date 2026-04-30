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

    {{-- HEADER --}}
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
                🏍 Módulo Motos
            </div>
            <div class="jm-date">
                {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM YYYY') }}
            </div>
        </div>
    </div>

    {{-- FORMULARIO --}}
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4">

                <div class="card-header text-white text-center"
                     style="background:linear-gradient(135deg,#7a4e00,#d6a531);">
                    <h4 class="mb-0">✏️ Editar {{ $moto->placa }}</h4>
                </div>

                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('motos.update', $moto) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Placa</label>
                            <input type="text" value="{{ $moto->placa }}" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Marca <span class="text-danger">*</span></label>
                            <input type="text" name="marca" value="{{ old('marca', $moto->marca) }}" class="form-control @error('marca') is-invalid @enderror" required>
                            @error('marca') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Modelo <span class="text-danger">*</span></label>
                            <input type="text" name="modelo" value="{{ old('modelo', $moto->modelo) }}" class="form-control @error('modelo') is-invalid @enderror" required>
                            @error('modelo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Cliente <span class="text-danger">*</span></label>
                            <select name="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
                                <option value="">Selecciona cliente...</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ old('cliente_id', $moto->cliente_id) == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->nombre }} {{ $cliente->apellido }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cliente_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Estado <span class="text-danger">*</span></label>
                            <select name="estado" class="form-select @error('estado') is-invalid @enderror" required>
                                <option value="1" {{ old('estado', $moto->estado) == 1 ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ old('estado', $moto->estado) == 0 ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            @error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('motos.index') }}" class="btn btn-secondary me-md-2">
                                Cancelar
                            </a>

                            <button type="submit"
                                    class="btn text-white"
                                    style="background:linear-gradient(135deg,#7a4e00,#d6a531); border:none;">
                                Actualizar Moto
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

</div>

@endsection