@extends('layouts.app')

@section('content')

<h3 class="mb-3">Trabajadores</h3>

<a href="{{ route('trabajadores.create') }}" class="btn btn-primary mb-3">
    Nuevo Trabajador
</a>

<div class="card p-3">

<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>CI</th>
            <th>Teléfono</th>
            <th>Salario</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        @forelse($trabajadores as $t)
        <tr>
            <td>{{ $t->id }}</td>
            <td>{{ $t->nombre }}</td>
            <td>{{ $t->ci }}</td>
            <td>{{ $t->telefono }}</td>
            <td>{{ $t->salario }}</td>
            <td>
                <span class="badge bg-{{ $t->estado == 'activo' ? 'success' : 'danger' }}">
                    {{ $t->estado }}
                </span>
            </td>

            <td>
                <a href="{{ route('trabajadores.edit', $t->id) }}" class="btn btn-warning btn-sm">
                    Editar
                </a>

                <form action="{{ route('trabajadores.destroy', $t->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar trabajador?')">
                        Eliminar
                    </button>
                </form>
            </td>
        </tr>

        @empty
        <tr>
            <td colspan="7" class="text-center">
                No hay trabajadores registrados
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

</div>

@endsection