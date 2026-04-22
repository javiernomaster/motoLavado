@extends('layouts.app')

@section('content')

<h3 class="mb-3">Servicios</h3>

<a href="{{ route('servicios.create') }}" class="btn btn-primary mb-3">
    Nuevo Servicio
</a>

<div class="card p-3">

<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Tiempo</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        @forelse($servicios as $s)
        <tr>
            <td>{{ $s->id }}</td>
            <td>{{ $s->nombre }}</td>
            <td>{{ $s->precio }}</td>
            <td>{{ $s->tiempo_estimado }} min</td>
            <td>
                <span class="badge bg-{{ $s->estado == 'activo' ? 'success' : 'danger' }}">
                    {{ $s->estado }}
                </span>
            </td>

            <td>
                <a href="{{ route('servicios.edit', $s->id) }}" class="btn btn-warning btn-sm">
                    Editar
                </a>

                <form action="{{ route('servicios.destroy', $s->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar servicio?')">
                        Eliminar
                    </button>
                </form>
            </td>
        </tr>

        @empty
        <tr>
            <td colspan="6" class="text-center">
                No hay servicios registrados
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

</div>

@endsection