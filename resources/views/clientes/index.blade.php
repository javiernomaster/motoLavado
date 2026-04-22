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
                <th>Teléfono</th>
                <th>Dirección</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clientes as $c)
            <tr>
                <td>{{ $c->id_cliente }}</td>
                <td>{{ $c->nombre }}</td>
                <td>{{ $c->telefono }}</td>
                <td>{{ $c->direccion }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">
                    No hay clientes registrados
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection