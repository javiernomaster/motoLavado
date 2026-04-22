@extends('layouts.app')

@section('content')

<h3>Nuevo Trabajador</h3>

@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('trabajadores.store') }}">
@csrf

<input name="nombre" class="form-control mb-2" placeholder="Nombre">
<input name="ci" class="form-control mb-2" placeholder="CI">
<input name="telefono" class="form-control mb-2" placeholder="Teléfono">
<input name="direccion" class="form-control mb-2" placeholder="Dirección">

<label>Porcentaje de comisión (%)</label>
<input name="porcentaje_comision" class="form-control mb-2" placeholder="Ej: 40">

<select name="estado" class="form-control mb-2">
    <option value="activo">Activo</option>
    <option value="inactivo">Inactivo</option>
</select>

<button class="btn btn-success">Guardar</button>

</form>

@endsection