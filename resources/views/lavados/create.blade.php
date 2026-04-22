@extends('layouts.app')

@section('content')

<h3>Nuevo Lavado</h3>

<form action="{{ route('lavados.store') }}" method="POST">
    @csrf

    <div class="mb-2">
        <label>Fecha</label>
        <input type="date" name="fecha" class="form-control" required>
    </div>

    <div class="mb-2">
        <label>Cliente</label>
        <select name="id_cliente" class="form-control" required>
            @foreach($clientes as $c)
                <option value="{{ $c->id_cliente }}">{{ $c->nombre }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-2">
        <label>Moto</label>
        <select name="placa" class="form-control" required>
            @foreach($motos as $m)
                <option value="{{ $m->placa }}">{{ $m->placa }}</option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-success">Guardar</button>

</form>

@endsection