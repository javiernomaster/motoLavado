@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">🏍 Motos</h3>

        <div class="d-flex gap-2">
            {{-- BOTÓN VOLVER --}}
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                ⬅ Volver al inicio
            </a>

            {{-- BOTÓN NUEVA MOTO --}}
            <a href="{{ route('motos.create') }}" class="btn btn-primary">
                ➕ Nueva Moto
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle text-center">

                    <thead class="table-dark">
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
                                <td class="fw-bold">{{ $m->placa }}</td>
                                <td>{{ $m->marca }}</td>
                                <td>{{ $m->modelo }}</td>

                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ $m->cliente->nombre ?? 'Sin cliente' }}
                                    </span>
                                </td>

                                <td class="d-flex justify-content-center gap-2">

                                    <a href="{{ route('motos.edit', $m->placa) }}"
                                       class="btn btn-warning btn-sm">
                                        ✏️ Editar
                                    </a>

                                    <form action="{{ route('motos.destroy', $m->placa) }}"
                                          method="POST"
                                          onsubmit="return confirm('¿Eliminar esta moto?')">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm">
                                            🗑 Eliminar
                                        </button>

                                    </form>

                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="text-muted py-4">
                                    No hay motos registradas
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