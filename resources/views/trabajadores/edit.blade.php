@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Servicio</h2>

    <form action="{{ route('servicios.update', $servicio) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ $servicio->nombre }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Precio (Bs)</label>
            <input type="number" name="precio" step="0.01" value="{{ $servicio->precio }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control">{{ $servicio->descripcion }}</textarea>
        </div>

        <div class="mb-3">
            <label>Estado</label>
            <select name="estado" class="form-control">
                <option value="activo" {{ $servicio->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                <option value="inactivo" {{ $servicio->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <button class="btn btn-success">Actualizar</button>
    </form>
</div>
@endsection