@extends('layouts.app')

@section('content')

<style>
/* HEADER JM */
.jm-header {
    background: linear-gradient(135deg, #071a38 0%, #0b2f5b 45%, #114c8d 100%);
    color: #fff;
    padding: 22px 32px;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(7,26,56,.30);
    margin-bottom: 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.jm-header-left {
    display: flex;
    align-items: center;
    gap: 16px;
}
.jm-header-title {
    font-size: 20px;
    font-weight: 800;
}
.jm-header-subtitle {
    font-size: 13px;
    opacity: .8;
}
.jm-header-module {
    background: rgba(255,255,255,.15);
    padding: 5px 14px;
    border-radius: 50px;
    font-size: 13px;
}
.jm-date {
    font-size: 13px;
    opacity: .85;
    margin-top: 5px;
}
</style>

<div class="container mt-4">

    {{-- HEADER NUEVO --}}
    <div class="jm-header">
        <div class="jm-header-left">
            <img src="{{ asset('images/logoM.png') }}"
                 style="width:60px;height:60px;object-fit:contain;">
            <div>
                <div class="jm-header-title">SISTEMA JM</div>
                <div class="jm-header-subtitle">Panel de control</div>
            </div>
        </div>

        <div>
            <div class="jm-header-module">
                👨‍🔧 Módulo Trabajadores
            </div>
            <div class="jm-date">
                {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM YYYY') }}
            </div>
        </div>
    </div>

    {{-- CABECERA ORIGINAL (NO TOCADA) --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary me-2">
                ⬅ Volver al inicio
            </a>
            <h3 class="mb-0 d-inline">👨‍🔧 Trabajadores</h3>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('trabajadores.papelera') }}" class="btn btn-outline-dark">
                🗑 Papelera
            </a>

            <a href="{{ route('trabajadores.create') }}" 
               class="btn text-white"
               style="background:linear-gradient(135deg,#0b2f5b,#114c8d); border:none;">
                ➕ Nuevo Trabajador
            </a>
        </div>
    </div>

    {{-- MENSAJES --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- BUSCADOR --}}
    <div class="card shadow-sm border-0 rounded-4 mb-3">
        <div class="card-body">
            <form action="{{ route('trabajadores.index') }}" method="GET" class="row g-2">
                <div class="col-md-8">
                    <input type="text" name="buscar" value="{{ request('buscar') }}"
                           class="form-control" placeholder="Buscar por nombre, CI o teléfono...">
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-outline-primary w-100">🔍 Buscar</button>
                    @if(request('buscar'))
                        <a href="{{ route('trabajadores.index') }}" class="btn btn-outline-secondary w-100">
                            Limpiar
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- CONTADOR --}}
    @if($trabajadores instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="mb-2 text-muted">
            <small>
                Mostrando {{ $trabajadores->firstItem() }}
                - {{ $trabajadores->lastItem() }}
                de {{ $trabajadores->total() }} trabajador(es)
            </small>
        </div>
    @endif

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
                            <th>Lavados</th>
                            <th>Comisión</th>
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
                                <td>
                                    <span class="badge bg-primary rounded-pill">
                                        {{ $t->lavados_count ?? 0 }} lavados
                                    </span>
                                </td>
                                <td>{{ $t->porcentaje_comision }}%</td>

                                <td>
                                    <div class="d-flex justify-content-center gap-2">

                                        <a href="{{ route('trabajadores.show', $t->id) }}"
                                           class="btn btn-info btn-sm text-white">
                                            Ver
                                        </a>

                                        <a href="{{ route('trabajadores.edit', $t->id) }}"
                                           class="btn btn-warning btn-sm">
                                            Editar
                                        </a>

                                        <form action="{{ route('trabajadores.destroy', $t->id) }}"
                                              method="POST" class="form-eliminar d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Eliminar
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="7" class="text-muted py-4">
                                    No hay trabajadores registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINACIÓN --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $trabajadores->appends(request()->query())->links() }}
            </div>

        </div>
    </div>

</div>

@endsection