@extends('layouts.app')

@section('content')
<h3>Editar Lavado</h3>

<form action="{{ route('lavados.update', $lavado->id_orden) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="mb-3">
        <label>Fecha</label>
        <input type="date" name="fecha" value="{{ $lavado->fecha }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Estado</label>
        <input type="text" name="estado" value="{{ $lavado->estado }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Cliente</label>
        <select name="cliente_id" class="form-control">
            @foreach($clientes as $c)
                <option value="{{ $c->id_cliente }}" {{ $lavado->cliente_id == $c->id_cliente ? 'selected' : '' }}>{{ $c->nombre }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Moto</label>
        <select name="moto_id" class="form-control">
            @foreach($motos as $m)
                <option value="{{ $m->id }}" {{ $lavado->moto_id == $m->id ? 'selected' : '' }}>{{ $m->placa }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Servicio</label>
        <select name="servicio_id" class="form-control">
            @foreach($servicios as $s)
                <option value="{{ $s->id }}" {{ $lavado->servicio_id == $s->id ? 'selected' : '' }}>{{ $s->nombre }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Trabajador</label>
        <select name="trabajador_id" class="form-control">
            @foreach($trabajadores as $t)
                <option value="{{ $t->id }}" {{ $lavado->trabajador_id == $t->id ? 'selected' : '' }}>{{ $t->nombre }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Precio Total</label>
        <input type="number" name="precio_total" step="0.01" value="{{ $lavado->precio_total }}" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('lavados.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
