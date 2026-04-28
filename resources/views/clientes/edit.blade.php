@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <a href="{{ route('clientes.index') }}" class="btn btn-secondary me-2">
                        ⬅ Volver
                    </a>
                    <h3 class="mb-0 d-inline">✏️ Editar Cliente</h3>
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

                    <form method="POST" action="{{ route('clientes.update', $cliente->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input name="nombre" value="{{ old('nombre', $cliente->nombre) }}" class="form-control @error('nombre') is-invalid @enderror">
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">CI <span class="text-danger">*</span></label>
                            <input name="ci" value="{{ old('ci', $cliente->ci) }}" class="form-control @error('ci') is-invalid @enderror">
                            @error('ci')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Teléfono</label>
                            <input name="telefono" value="{{ old('telefono', $cliente->telefono) }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Dirección</label>
                            <input name="direccion" value="{{ old('direccion', $cliente->direccion) }}" class="form-control">
                        </div>

                        <button class="btn btn-primary w-100">💾 Actualizar Cliente</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
