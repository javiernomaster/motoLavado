@extends('layouts.app')

@section('content')

<h3 class="mb-4">Lavados</h3>

<a href="{{ route('lavados.create') }}" class="btn btn-primary mb-3">
    Nuevo Lavado
</a>

<div class="card p-3">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Moto</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lavados as $l)
            <tr>
                <td>{{ $l->id_orden }}</td>
                <td>{{ $l->cliente->nombre }}</td>
                <td>{{ $l->moto->placa }}</td>
                <td>{{ $l->fecha }}</td>
                <td>{{ $l->estado }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No hay lavados</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection