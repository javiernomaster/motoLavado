@extends('layouts.app')

@section('content')

<h3 class="mb-4">Motos</h3>

<a href="{{ route('motos.create') }}" class="btn btn-primary mb-3">
    Nueva Moto
</a>

<div class="card p-3">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Placa</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Cliente</th>
            </tr>
        </thead>
        <tbody>
            @forelse($motos as $m)
            <tr>
                <td>{{ $m->placa }}</td>
                <td>{{ $m->marca }}</td>
                <td>{{ $m->modelo }}</td>
                <td>{{ $m->cliente->nombre ?? 'Sin cliente' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4">No hay motos registradas</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection