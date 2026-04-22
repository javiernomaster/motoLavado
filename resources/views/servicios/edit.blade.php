@extends('layouts.app')

@section('content')

<h3>Editar Servicio</h3>

@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('servicios.update', $servicio->id) }}">
@csrf
@method('PUT')

<input name="nombre" value="{{ $servicio->nombre }}" class="form-control mb-2">

<textarea name="descripcion" class="form-control mb-2">{{ $servicio->descripcion }}</textarea>

<input name="precio" value="{{ $servicio->precio }}" class="form-control mb-2">

<input name="tiempo_estimado" value="{{ $servicio->tiempo_estimado }}" class="form-control mb-2">

<select name="estado" class="form-control mb-2">
    <option value="activo" {{ $servicio->estado == 'activo' ? 'selected' : '' }}>Activo</option>
    <option value="inactivo" {{ $servicio->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
</select>

<button class="btn btn-primary">Actualizar</button>

</form>

@endsection