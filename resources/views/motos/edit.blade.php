@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-warning text-white text-center">
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
                            <a href="{{ route('motos.index') }}" class="btn btn-secondary me-md-2">Cancelar</a>
                            <button type="submit" class="btn btn-warning">Actualizar Moto</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

