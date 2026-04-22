@extends('layouts.app')

@section('content')

<h3>Nueva Moto</h3>

@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('motos.store') }}">
@csrf

<input name="placa" class="form-control mb-2" placeholder="Placa">
<input name="marca" class="form-control mb-2" placeholder="Marca">
<input name="modelo" class="form-control mb-2" placeholder="Modelo">

<select name="cliente_id" class="form-control mb-2">
    <option value="">Seleccione cliente</option>
    @foreach($clientes as $c)
        <option value="{{ $c->id }}">{{ $c->nombre }}</option>
    @endforeach
</select>

<button class="btn btn-success">Guardar</button>

</form>

@endsection