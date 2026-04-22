@extends('layouts.app')

@section('content')

<h3 class="mb-4">Clientes</h3>

<a href="{{ route('clientes.create') }}" class="btn btn-primary mb-3">
    Nuevo Cliente
</a>

<div class="card p-3">
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>CI</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse($clientes as $c)
            <tr>
                <td>{{ $c->id }}</td>
                <td>{{ $c->nombre }}</td>
                <td>{{ $c->ci }}</td>
                <td>{{ $c->telefono }}</td>
                <td>{{ $c->direccion }}</td>
                <td>
                    <a href="{{ route('clientes.edit', $c->id) }}" class="btn btn-warning btn-sm">Editar</a>

                    <form action="{{ route('clientes.destroy', $c->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No hay clientes registrados</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection