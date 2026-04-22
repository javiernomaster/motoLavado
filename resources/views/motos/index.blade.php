@extends('layouts.app')

@section('content')

<h3 class="mb-3">Motos</h3>

<a href="{{ route('motos.create') }}" class="btn btn-primary mb-3">
    Nueva Moto
</a>

<div class="card p-3">

<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>Placa</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Cliente</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        @forelse($motos as $m)
        <tr>
            <td>{{ $m->placa }}</td>
            <td>{{ $m->marca }}</td>
            <td>{{ $m->modelo }}</td>
            <td>{{ $m->cliente->nombre ?? 'Sin cliente' }}</td>

            <td>
                <a href="{{ route('motos.edit', $m->placa) }}" class="btn btn-warning btn-sm">
                    Editar
                </a>

                <form action="{{ route('motos.destroy', $m->placa) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Eliminar esta moto?')">
                        Eliminar
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">
                No hay motos registradas
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

</div>

@endsection