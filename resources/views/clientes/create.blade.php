@extends('layouts.app')

@section('content')

<h3>Nuevo Cliente</h3>

<form method="POST" action="{{ route('clientes.store') }}">
    @csrf

    <input name="nombre" class="form-control mb-2" placeholder="Nombre">

    <input name="ci" class="form-control mb-2" placeholder="CI">

    <input name="telefono" class="form-control mb-2" placeholder="Teléfono">

    <input name="direccion" class="form-control mb-2" placeholder="Dirección">

    <button class="btn btn-success">Guardar</button>
</form>

@endsection