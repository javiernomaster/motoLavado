@extends('layouts.app')

@section('content')

<h3>Editar Trabajador</h3>

<form method="POST" action="{{ route('trabajadores.update', $trabajador->id) }}">
@csrf
@method('PUT')

<input name="nombre" value="{{ $trabajador->nombre }}" class="form-control mb-2">
<input name="ci" value="{{ $trabajador->ci }}" class="form-control mb-2">
<input name="telefono" value="{{ $trabajador->telefono }}" class="form-control mb-2">
<input name="direccion" value="{{ $trabajador->direccion }}" class="form-control mb-2">
<input name="salario" value="{{ $trabajador->salario }}" class="form-control mb-2">

<select name="estado" class="form-control mb-2">
    <option value="activo" {{ $trabajador->estado == 'activo' ? 'selected' : '' }}>Activo</option>
    <option value="inactivo" {{ $trabajador->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
</select>

<button class="btn btn-primary">Actualizar</button>

</form>

@endsection