@extends('layouts.app')

@section('content')

<h3>Editar Cliente</h3>

<form method="POST" action="{{ route('clientes.update', $cliente->id) }}">
    @csrf
    @method('PUT')

    <input name="nombre" value="{{ $cliente->nombre }}" class="form-control mb-2">

    <input name="ci" value="{{ $cliente->ci }}" class="form-control mb-2">

    <input name="telefono" value="{{ $cliente->telefono }}" class="form-control mb-2">

    <input name="direccion" value="{{ $cliente->direccion }}" class="form-control mb-2">

    <button class="btn btn-primary">Actualizar</button>
</form>

@endsection