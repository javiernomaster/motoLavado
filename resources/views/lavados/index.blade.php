@extends('layouts.app')

@section('content')
<h3>Lavados</h3>

<a href="{{ route('lavados.create') }}" class="btn btn-primary mb-3">+ Nuevo Lavado</a>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Cliente</th>
                <th>Moto</th>
                <th>Servicio</th>
                <th>Trabajador</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lavados as $lavado)
            <tr>
                <td>{{ $lavado->id_orden }}</td>
                <td>{{ $lavado->fecha }}</td>
                <td><span class="badge bg-info">{{ $lavado->estado }}</span></td>
                <td>{{ $lavado->cliente->nombre }}</td>
                <td>{{ $lavado->moto->placa }}</td>
                <td>{{ $lavado->servicio->nombre }}</td>
                <td>{{ $lavado->trabajador->nombre }}</td>
                <td>${{ number_format($lavado->precio_total, 2) }}</td>
                <td>
                    <a href="{{ route('lavados.show', $lavado) }}" class="btn btn-sm btn-info">Ver</a>
                    <a href="{{ route('lavados.edit', $lavado) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('lavados.destroy', $lavado) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">No hay lavados registrados</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
