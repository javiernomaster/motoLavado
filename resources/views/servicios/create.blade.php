@extends('layouts.app')

@section('content')

<h3>Nuevo Servicio</h3>

@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('servicios.store') }}">
@csrf

<input name="nombre" class="form-control mb-2" placeholder="Nombre">

<textarea name="descripcion" class="form-control mb-2" placeholder="Descripción"></textarea>

<input name="precio" class="form-control mb-2" placeholder="Precio">

<input name="tiempo_estimado" class="form-control mb-2" placeholder="Tiempo estimado (minutos)">

<select name="estado" class="form-control mb-2">
    <option value="activo">Activo</option>
    <option value="inactivo">Inactivo</option>
</select>

<button class="btn btn-success">Guardar</button>

</form>

@endsection