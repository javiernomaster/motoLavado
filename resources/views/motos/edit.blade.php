@extends('layouts.app')

@section('content')

<h3>Editar Moto</h3>

@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('motos.update', $moto->placa) }}">
@csrf
@method('PUT')

<input name="marca" value="{{ $moto->marca }}" class="form-control mb-2">
<input name="modelo" value="{{ $moto->modelo }}" class="form-control mb-2">

<select name="cliente_id" class="form-control mb-2">
    @foreach($clientes as $c)
        <option value="{{ $c->id }}"
        {{ $moto->cliente_id == $c->id ? 'selected' : '' }}>
            {{ $c->nombre }}
        </option>
    @endforeach
</select>

<button class="btn btn-primary">Actualizar</button>

</form>

@endsection