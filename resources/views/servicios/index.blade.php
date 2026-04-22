@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Servicios</h3>

    <a href="#" class="btn btn-primary">
        + Nuevo Servicio
    </a>
</div>

<div class="card p-3">

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Estado</th>
            </tr>
        </thead>

        <tbody>
            @forelse($servicios as $servicio)
                <tr>
                    <td>{{ $servicio->id }}</td>
                    <td>{{ $servicio->nombre }}</td>
                    <td>{{ $servicio->descripcion }}</td>
                    <td>{{ $servicio->precio }}</td>
                    <td>{{ $servicio->estado ? 'Activo' : 'Inactivo' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No hay servicios registrados</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection