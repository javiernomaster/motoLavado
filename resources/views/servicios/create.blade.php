@extends('layouts.app')

@section('content')

<div class="container mt-4">

<div class="card shadow border-0">
<div class="card-header bg-primary text-white">
<h4 class="mb-0">
Nuevo Servicio
</h4>
</div>

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


<form method="POST"
action="{{ route('servicios.store') }}">

@csrf


<!-- NOMBRE -->
<div class="mb-3">
<label class="form-label">
Nombre del Servicio
</label>

<input
type="text"
name="nombre"
class="form-control"
placeholder="Ej. Lavado Premium"
required>

</div>



<!-- DESCRIPCION -->
<div class="mb-3">
<label class="form-label">
Descripción
</label>

<textarea
name="descripcion"
class="form-control"
placeholder="Detalle del servicio">
</textarea>

</div>



<!-- PRECIO -->
<div class="mb-3">
<label class="form-label">
Precio (Bs)
</label>

<input
type="number"
step="0.01"
min="1"
name="precio"
class="form-control"
placeholder="Ej. 25"
required>

</div>



<!-- TIEMPO -->
<div class="mb-3">
<label class="form-label">
Tiempo estimado (minutos)
</label>

<input
type="number"
min="1"
name="tiempo_estimado"
class="form-control"
placeholder="Ej. 15"
required>

</div>



<!-- ESTADO -->
<div class="mb-4">
<label class="form-label">
Estado
</label>

<select
name="estado"
class="form-control">

<option value="1">
Activo
</option>

<option value="0">
Inactivo
</option>

</select>

</div>



<button class="btn btn-success">
Guardar Servicio
</button>

<a href="{{ route('servicios.index') }}"
class="btn btn-secondary">
Cancelar
</a>

</form>

</div>
</div>
</div>

@endsection