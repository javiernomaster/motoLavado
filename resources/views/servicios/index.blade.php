@extends('layouts.app')

@section('content')

<div class="container mt-4">

    {{-- CABECERA --}}
    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary me-2">
                ⬅ Volver al inicio
            </a>

            <h3 class="mb-0 d-inline">🧼 Servicios</h3>
        </div>

        <a href="{{ route('servicios.create') }}" class="btn btn-primary">
            ➕ Nuevo Servicio
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
                            <th>Nombre</th>
                            <th>Precio (Bs)</th>
                            <th>Tiempo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($servicios as $s)

                            <tr>
                                <td>{{ $s->id }}</td>
                                <td class="fw-semibold">{{ $s->nombre }}</td>
                                <td>Bs {{ $s->precio }}</td>
                                <td>{{ $s->tiempo_estimado }} min</td>

                                {{-- Estado --}}
                                <td>
                                    @if($s->estado == 'activo')
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </td>

                                {{-- ACCIONES --}}
                                <td class="d-flex justify-content-center gap-2">

                                    <a href="{{ route('servicios.edit', $s->id) }}"
                                       class="btn btn-warning btn-sm">
                                        ✏️ Editar
                                    </a>

                                    <form action="{{ route('servicios.destroy', $s->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('¿Eliminar servicio?')">

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
                                <td colspan="6" class="text-muted py-4">
                                    No hay servicios registrados
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