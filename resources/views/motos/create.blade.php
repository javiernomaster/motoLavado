@extends('layouts.app')

@section('content')

<h3>Nueva Moto</h3>

<form action="{{ route('motos.store') }}" method="POST">
    @csrf

    <div class="mb-2">
        <input type="text" name="placa" class="form-control" placeholder="Placa" required>
    </div>

    <div class="mb-2">
        <input type="text" name="marca" class="form-control" placeholder="Marca">
    </div>

    <div class="mb-2">
        <input type="text" name="modelo" class="form-control" placeholder="Modelo">
    </div>

    <div class="mb-2">
        <input type="text" name="tipo_moto" class="form-control" placeholder="Tipo">
    </div>

    <div class="mb-2">
        <input type="text" name="cilindraje" class="form-control" placeholder="Cilindraje">
    </div>

    <div class="mb-2">
        <input type="text" name="color" class="form-control" placeholder="Color">
    </div>

    <div class="mb-2">
        <select name="id_cliente" class="form-control">
            <option value="">Seleccione Cliente</option>
            @foreach($clientes as $c)
                <option value="{{ $c->id_cliente }}">{{ $c->nombre }}</option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-success">Guardar</button>
</form>

@endsection