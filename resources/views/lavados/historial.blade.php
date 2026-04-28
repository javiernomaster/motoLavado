@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('lavados.index') }}" class="btn btn-secondary me-2">
                ⬅ Volver a Lavados
            </a>
            <h3 class="mb-0 d-inline">📋 Historial del Lavado #{{ $lavado->id_orden }}</h3>
        </div>
        <a href="{{ route('lavados.show', $lavado->id_orden) }}" class="btn btn-info">
            Ver Lavado
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Estado Anterior</th>
                            <th>Estado Nuevo</th>
                            <th>Observación</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($historial as $h)
                            <tr>
                                <td>{{ $h->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $h->user->name ?? 'Sistema' }}</td>
                                <td>
                                    @if($h->estado_anterior)
                                        <span class="badge bg-secondary">{{ $h->estado_anterior }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $h->estado_nuevo }}</span>
                                </td>
                                <td class="text-muted">{{ $h->observacion ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-muted py-4 text-center">
                                    No hay registros de historial
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

