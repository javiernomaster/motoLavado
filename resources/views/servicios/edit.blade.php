@extends('layouts.app')

@section('content')

<style>
/* HEADER JM */
.jm-header {
    background: linear-gradient(135deg, #071a38 0%, #0b2f5b 45%, #114c8d 100%);
    color: #fff;
    padding: 20px 30px;
    border-radius: 16px;
    margin-bottom: 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.jm-header-title { font-weight: 800; font-size: 20px; }
.jm-header-sub { font-size: 13px; opacity: .8; }
.jm-module {
    background: rgba(255,255,255,.15);
    padding: 5px 14px;
    border-radius: 50px;
    font-size: 13px;
}
.jm-date { font-size: 13px; opacity: .85; }
</style>

<div class="container mt-4">

    {{-- HEADER NUEVO --}}
    <div class="jm-header">
        <div>
            <div class="jm-header-title">SISTEMA JM</div>
            <div class="jm-header-sub">Panel de control</div>
        </div>

        <div class="text-end">
            <div class="jm-module">🧼 Módulo Servicios</div>
            <div class="jm-date">
                {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM YYYY') }}
            </div>
        </div>
    </div>

    {{-- TU CONTENIDO ORIGINAL (NO TOCADO) --}}
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <a href="{{ route('servicios.index') }}" class="btn btn-secondary me-2">
                        ⬅ Volver
                    </a>
                    <h3 class="mb-0 d-inline">✏️ Editar {{ $servicio->nombre }}</h3>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4">
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

                    <form method="POST" action="{{ route('servicios.update', $servicio) }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input name="nombre" value="{{ old('nombre', $servicio->nombre) }}" class="form-control @error('nombre') is-invalid @enderror" required>
                            @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" rows="3">{{ old('descripcion', $servicio->descripcion) }}</textarea>
                            @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Precio (Bs) <span class="text-danger">*</span></label>
                            <input name="precio" type="number" step="0.01" min="0.01" value="{{ old('precio', $servicio->precio) }}" class="form-control @error('precio') is-invalid @enderror" required>
                            @error('precio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tiempo estimado (min)</label>
                            <input name="tiempo_estimado" type="number" min="1" value="{{ old('tiempo_estimado', $servicio->tiempo_estimado) }}" class="form-control @error('tiempo_estimado') is-invalid @enderror">
                            @error('tiempo_estimado') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Estado <span class="text-danger">*</span></label>
                            <select name="estado" class="form-control @error('estado') is-invalid @enderror" required>
                                <option value="">Seleccionar</option>
                                <option value="activo" {{ old('estado', $servicio->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ old('estado', $servicio->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            @error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('servicios.index') }}" class="btn btn-secondary me-md-2">Cancelar</a>
                            <button class="btn btn-primary">💾 Actualizar</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

@endsection