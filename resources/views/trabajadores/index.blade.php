@extends('layouts.app')

@section('content')

<div class="container mt-4">

    {{-- CABECERA --}}
    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary me-2">
                ⬅ Volver al inicio
            </a>

            <h3 class="mb-0 d-inline">👨‍🔧 Trabajadores</h3>
        </div>

        <a href="{{ route('trabajadores.create') }}" class="btn btn-primary">
            ➕ Nuevo Trabajador
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
                            <th>CI</th>
                            <th>Teléfono</th>
                            <th>Salario</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($trabajadores as $t)

                            <tr>
                                <td>{{ $t->id }}</td>
                                <td class="fw-semibold">{{ $t->nombre }}</td>
                                <td>{{ $t->ci }}</td>
                                <td>{{ $t->telefono }}</td>
                                <td>Bs {{ $t->salario }}</td>

                                {{-- Estado --}}
                                <td>
                                    @if($t->estado == 'activo')
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </td>

                                {{-- ACCIONES --}}
                                <td class="d-flex justify-content-center gap-2">

                                    <a href="{{ route('trabajadores.edit', $t->id) }}"
                                       class="btn btn-warning btn-sm">
                                        ✏️ Editar
                                    </a>

                                    <form action="{{ route('trabajadores.destroy', $t->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('¿Eliminar trabajador?')">

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
                                <td colspan="7" class="text-muted py-4">
                                    No hay trabajadores registrados
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