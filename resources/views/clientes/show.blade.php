@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- CABECERA --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('clientes.index') }}" class="btn btn-secondary me-2">
                ⬅ Volver
            </a>
            <h3 class="mb-0 d-inline">👤 {{ $cliente->nombre }}</h3>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('lavados.create') }}?cliente_id={{ $cliente->id }}" class="btn btn-success">
                ➕ Nuevo Lavado
            </a>
            <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning">
                ✏️ Editar
            </a>
            <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" class="form-eliminar">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">🗑 Eliminar</button>
            </form>
        </div>
    </div>

    {{-- ESTADÍSTICAS --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card card-box bg-white">
                <div class="card-body">
                    <h6 class="text-muted">Total Lavados</h6>
                    <h3 class="mb-0">{{ $totalLavados }}</h3>
                    <div class="card-icon bg-blue"><i class="bi bi-droplet"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-box bg-white">
                <div class="card-body">
                    <h6 class="text-muted">Total Gastado</h6>
                    <h3 class="mb-0">Bs. {{ number_format($totalGastado, 2) }}</h3>
                    <div class="card-icon bg-green"><i class="bi bi-cash-stack"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-box bg-white">
                <div class="card-body">
                    <h6 class="text-muted">Total Pagado</h6>
                    <h3 class="mb-0">Bs. {{ number_format($totalPagado, 2) }}</h3>
                    <div class="card-icon bg-cyan"><i class="bi bi-check-circle"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-box bg-white">
                <div class="card-body">
                    <h6 class="text-muted">Saldo Pendiente</h6>
                    <h3 class="mb-0 {{ $saldoPendiente > 0 ? 'text-danger' : 'text-success' }}">
                        Bs. {{ number_format($saldoPendiente, 2) }}
                    </h3>
                    <div class="card-icon bg-orange"><i class="bi bi-exclamation-triangle"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- INFORMACIÓN DEL CLIENTE --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-person"></i> Información</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="fw-semibold text-muted">CI:</td>
                            <td>{{ $cliente->ci }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-muted">Teléfono:</td>
                            <td>{{ $cliente->telefono ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-muted">Dirección:</td>
                            <td>{{ $cliente->direccion ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-muted">Registrado:</td>
                            <td>{{ $cliente->created_at?->format('d/m/Y') ?? '—' }}</td>
                        </tr>
                        @if($ultimaVisita && $ultimaVisita->fecha)
                        <tr>
                            <td class="fw-semibold text-muted">Última visita:</td>
                            <td>{{ $ultimaVisita->fecha->format('d/m/Y') }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            {{-- MOTOS REGISTRADAS --}}
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-bicycle"></i> Motos ({{ $cliente->motos->count() }})</h5>
                    <a href="{{ route('motos.create') }}?cliente_id={{ $cliente->id }}" class="btn btn-sm btn-light">
                        ➕ Agregar
                    </a>
                </div>
                <div class="card-body p-0">
                    @if($cliente->motos->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($cliente->motos as $moto)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-semibold">{{ $moto->marca }} {{ $moto->modelo }}</div>
                                        <small class="text-muted">{{ $moto->placa }}</small>
                                    </div>
                                    <span class="badge bg-primary rounded-pill">{{ $moto->lavados->count() }} lavados</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center text-muted py-4">
                            No hay motos registradas
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- HISTORIAL DE LAVADOS --}}
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-clock-history"></i> Historial de Lavados</h5>
                </div>
                <div class="card-body">
                    @if($cliente->lavados->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Moto</th>
                                        <th>Servicio</th>
                                        <th>Trabajador</th>
                                        <th>Total</th>
                                        <th>Estado Pago</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cliente->lavados->sortByDesc('fecha') as $lavado)
                                        <tr style="cursor: pointer;" onclick="window.location='{{ route('lavados.show', $lavado->id_orden) }}'">
                                            <td>{{ $lavado->fecha->format('d/m/Y') }}</td>
                                            <td>{{ $lavado->moto->marca }} {{ $lavado->moto->modelo }}<br><small class="text-muted">{{ $lavado->moto->placa }}</small></td>
                                            <td>{{ $lavado->servicio->nombre ?? '—' }}</td>
                                            <td>{{ $lavado->trabajador->nombre ?? '—' }}</td>
                                            <td>Bs. {{ number_format($lavado->precio_total, 2) }}</td>
                                            <td>
                                                @if($lavado->estado_pago == 'pagado')
                                                    <span class="badge bg-success">Pagado</span>
                                                @elseif($lavado->estado_pago == 'parcial')
                                                    <span class="badge bg-warning text-dark">Parcial</span>
                                                @else
                                                    <span class="badge bg-danger">Pendiente</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ ucfirst($lavado->estado) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1"></i>
                            <p class="mt-2">No hay lavados registrados para este cliente</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.form-eliminar').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Eliminar cliente?',
                text: '{{ $cliente->nombre }} se moverá a la papelera.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush

@endsection

