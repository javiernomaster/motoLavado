@extends('layouts.app')

@section('content')

<div class="container mt-4">

    {{-- CABECERA --}}
    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary me-2">
                ⬅ Volver al inicio
            </a>

            <h3 class="mb-0 d-inline">👤 Clientes</h3>
        </div>

        <a href="{{ route('clientes.create') }}" class="btn btn-primary">
            ➕ Nuevo Cliente
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
                            <th>Dirección</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($clientes as $c)

                            <tr>
                                <td>{{ $c->id }}</td>
                                <td class="fw-semibold">{{ $c->nombre }}</td>
                                <td>{{ $c->ci }}</td>
                                <td>{{ $c->telefono }}</td>
                                <td>{{ $c->direccion }}</td>

                                {{-- ACCIONES --}}
                                <td class="d-flex justify-content-center gap-2">

                                    <a href="{{ route('clientes.edit', $c->id) }}"
                                       class="btn btn-warning btn-sm">
                                        ✏️ Editar
                                    </a>

                                    <form action="{{ route('clientes.destroy', $c->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('¿Eliminar cliente?')">

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
                                    No hay clientes registrados
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