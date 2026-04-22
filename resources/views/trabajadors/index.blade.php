@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Trabajadores</h3>
<h1>SERVICIOS FUNCIONA</h1>
    <a href="#" class="btn btn-primary">
        + Nuevo Trabajador
    </a>
</div>

<div class="card p-3">

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>CI</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Salario</th>
            </tr>
        </thead>

        <tbody>
            @forelse($trabajadors as $t)
                <tr>
                    <td>{{ $t->id }}</td>
                    <td>{{ $t->nombre }}</td>
                    <td>{{ $t->ci }}</td>
                    <td>{{ $t->telefono }}</td>
                    <td>{{ $t->direccion }}</td>
                    <td>{{ $t->salario }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No hay trabajadores registrados</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection