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
                            <th>🏍 Motos</th>
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

                                {{-- MOTOS --}}
                                <td class="position-relative">
                                    @if($c->motos->count() > 0)
                                        <span class="badge bg-primary rounded-pill moto-badge"
                                              style="cursor: pointer;"
                                              data-motos="{{ $c->motos->map(fn($m) => $m->marca . ' ' . $m->modelo . ' — ' . $m->placa)->join('|') }}">
                                            {{ $c->motos->count() }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill">0</span>
                                    @endif
                                </td>

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
                                <td colspan="7" class="text-muted py-4">
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

<script>
document.addEventListener('DOMContentLoaded', function () {

    const tip = document.createElement('div');
    tip.style.cssText = `
        position: fixed;
        background: #212529;
        color: #fff;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 13px;
        line-height: 1.8;
        z-index: 9999;
        pointer-events: none;
        display: none;
        white-space: nowrap;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    `;
    document.body.appendChild(tip);

    document.querySelectorAll('.moto-badge').forEach(badge => {
        badge.addEventListener('mouseenter', function () {
            const motos = this.dataset.motos.split('|');
            tip.innerHTML = motos.map(m => '🏍 ' + m).join('<br>');
            tip.style.display = 'block';
        });

        badge.addEventListener('mousemove', function (e) {
            tip.style.left = (e.clientX + 12) + 'px';
            tip.style.top  = (e.clientY + 12) + 'px';
        });

        badge.addEventListener('mouseleave', function () {
            tip.style.display = 'none';
        });
    });

});
</script>

@endsection