@extends('layouts.app')

@section('content')

<div class="container mt-4">

<div class="card shadow border-0">

<div class="card-header bg-primary text-white">
<h4 class="mb-0">
Registrar Nuevo Lavado
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

<form action="{{ route('lavados.store') }}" method="POST">

@csrf

<!-- CLIENTE -->
<div class="mb-3">
<label class="form-label">Cliente</label>

<select name="cliente_id" class="form-control" required>

<option value="" disabled selected>Seleccione cliente</option>

@foreach($clientes as $c)
<option value="{{ $c->id }}">{{ $c->nombre }}</option>
@endforeach

</select>
</div>

<!-- MOTO -->
<div class="mb-3">
<label class="form-label">Moto</label>

<select name="moto_id" class="form-control" required>

<option value="" disabled selected>Seleccione moto</option>

@foreach($motos as $m)
<option value="{{ $m->id }}">{{ $m->placa }}</option>
@endforeach

</select>
</div>

<!-- SERVICIO -->
<div class="mb-3">
<label class="form-label">Servicio</label>

<select name="servicio_id" class="form-control" required>

<option value="" disabled selected>Seleccione servicio</option>

@foreach($servicios as $s)
<option value="{{ $s->id }}">{{ $s->nombre }} - Bs {{ $s->precio }}</option>
@endforeach

</select>
</div>

<!-- TRABAJADOR -->
<div class="mb-4">
<label class="form-label">Trabajador</label>

<select name="trabajador_id" class="form-control" required>

<option value="" disabled selected>Seleccione trabajador</option>

@foreach($trabajadores as $t)
<option value="{{ $t->id }}">{{ $t->nombre }}</option>
@endforeach

</select>
</div>

<button type="submit" class="btn btn-success">Guardar Lavado</button>

<a href="{{ route('lavados.index') }}" class="btn btn-secondary">Cancelar</a>

</form>

</div>
</div>
</div>

@endsection