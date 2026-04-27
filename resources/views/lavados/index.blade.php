@extends('layouts.app')

@section('content')

<div class="container mt-4">

    {{-- CABECERA --}}
    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary me-2">
                ⬅ Volver al inicio
            </a>

            <h3 class="mb-0 d-inline">🚿 Lista de Lavados</h3>
        </div>

        <a href="{{ route('lavados.create') }}" class="btn btn-primary">
            ➕ Nuevo Lavado
        </a>

    </div>

    {{-- TABLA --}}
    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle text-center">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Servicio</th>
                            <th>Trabajador</th>
                            <th>Moto (Modelo)</th>
                            <th>Fecha</th>
                            <th>Total a Pagar</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($lavados as $l)

                            <tr>
                                <td>{{ $l->id_orden }}</td>
                                <td>{{ $l->cliente->nombre ?? '—' }}</td>
                                <td>{{ $l->servicio->nombre ?? '—' }}</td>
                                <td>{{ $l->trabajador->nombre ?? '—' }}</td>
                                <td>{{ $l->moto->modelo ?? '—' }}</td>
                                <td>{{ $l->fecha }}</td>
                                <td>
                                    <strong>Bs. {{ number_format($l->precio_total, 2) }}</strong>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="text-muted py-4">
                                    No hay lavados registrados
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection