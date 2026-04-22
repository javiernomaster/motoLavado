@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Trabajador</h2>

    <form action="{{ route('trabajadores.update', $trabajador) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ $trabajador->nombre }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>CI</label>
            <input type="text" name="ci" value="{{ $trabajador->ci }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="telefono" value="{{ $trabajador->telefono }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Dirección</label>
            <input type="text" name="direccion" value="{{ $trabajador->direccion }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>% Comisión</label>
            <input type="number" name="porcentaje_comision" value="{{ $trabajador->porcentaje_comision }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Estado</label>
            <select name="estado" class="form-control">
                <option value="activo" {{ $trabajador->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                <option value="inactivo" {{ $trabajador->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <button class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection