@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <a href="{{ route('trabajadores.index') }}" class="btn btn-secondary me-2">
                        ⬅ Volver
                    </a>
                    <h3 class="mb-0 d-inline">✏️ Editar {{ $trabajador->nombre }}</h3>
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

                    <form method="POST" action="{{ route('trabajadores.update', $trabajador) }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input name="nombre" value="{{ old('nombre', $trabajador->nombre) }}" class="form-control @error('nombre') is-invalid @enderror">
                            @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">CI <span class="text-danger">*</span></label>
                            <input name="ci" value="{{ old('ci', $trabajador->ci) }}" class="form-control @error('ci') is-invalid @enderror">
                            @error('ci') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Teléfono</label>
                            <input name="telefono" value="{{ old('telefono', $trabajador->telefono) }}" class="form-control @error('telefono') is-invalid @enderror">
                            @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Dirección</label>
                            <input name="direccion" value="{{ old('direccion', $trabajador->direccion) }}" class="form-control @error('direccion') is-invalid @enderror">
                            @error('direccion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Comisión % <span class="text-danger">*</span></label>
                            <input name="porcentaje_comision" type="number" step="0.1" min="1" max="100" value="{{ old('porcentaje_comision', $trabajador->porcentaje_comision) }}" class="form-control @error('porcentaje_comision') is-invalid @enderror">
                            @error('porcentaje_comision') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('trabajadores.index') }}" class="btn btn-secondary me-md-2">Cancelar</a>
                            <button class="btn btn-primary">💾 Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

