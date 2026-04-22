@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Registrar Trabajador</h2>

    <form action="{{ route('trabajadores.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>CI</label>
            <input type="text" name="ci" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control">
        </div>

        <div class="mb-3">
            <label>Dirección</label>
            <input type="text" name="direccion" class="form-control">
        </div>

        <div class="mb-3">
            <label>Porcentaje de Comisión (%)</label>
            <input type="number" name="porcentaje_comision" min="1" max="100" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Estado</label>
            <select name="estado" class="form-control">
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
            </select>
        </div>

        <button class="btn btn-success">Guardar</button>
        <a href="{{ route('trabajadores.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection