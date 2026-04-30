@extends('layouts.app')

@section('content')

<style>
/* ── Header ── */
.jm-header {
    background: linear-gradient(135deg, #071a38 0%, #0b2f5b 45%, #114c8d 100%);
    color: #fff;
    padding: 22px 32px;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(7,26,56,.30);
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
}
.jm-header::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(circle at 80% 50%, rgba(47,109,246,.18) 0%, transparent 60%),
        radial-gradient(circle at 10% 80%, rgba(41,197,216,.10) 0%, transparent 50%);
    pointer-events: none;
}
.jm-header-left { display:flex; align-items:center; gap:16px; position:relative; }
.jm-header-title { font-size:20px; font-weight:800; letter-spacing:.6px; }
.jm-header-subtitle { font-size:13px; opacity:.80; margin-top:2px; }
.jm-header-module {
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.25);
    padding: 5px 16px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 600;
    position: relative;
}
.jm-header-right { display:flex; flex-direction:column; align-items:flex-end; gap:6px; position:relative; }
.jm-date { font-size:13px; opacity:.85; font-weight:500; }

/* ── Stat cards ── */
.jm-stat-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin-bottom: 28px;
}
.jm-stat {
    background: #fff;
    border-radius: 16px;
    padding: 22px 20px;
    box-shadow: 0 4px 16px rgba(0,0,0,.08);
    border-top: 4px solid transparent;
    display: flex;
    flex-direction: column;
    gap: 8px;
    position: relative;
    overflow: hidden;
}
.jm-stat::after {
    content: '';
    position: absolute;
    right: -10px; bottom: -10px;
    width: 70px; height: 70px;
    border-radius: 50%;
    opacity: .07;
}
.jm-stat-blue  { border-top-color: #2f6df6; } .jm-stat-blue::after  { background:#2f6df6; }
.jm-stat-green { border-top-color: #27ae60; } .jm-stat-green::after { background:#27ae60; }
.jm-stat-teal  { border-top-color: #29c5d8; } .jm-stat-teal::after  { background:#29c5d8; }
.jm-stat-red   { border-top-color: #e74c3c; } .jm-stat-red::after   { background:#e74c3c; }
.jm-stat-orange{ border-top-color: #d6a531; } .jm-stat-orange::after{ background:#d6a531; }

.jm-stat-label {
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .6px;
    color: #6b7280;
    display: flex;
    align-items: center;
    gap: 6px;
}
.jm-stat-value {
    font-size: 28px;
    font-weight: 800;
    line-height: 1;
    color: #1f2937;
}
.jm-stat-value.text-danger { color: #e74c3c; }
.jm-stat-value.text-success { color: #27ae60; }

/* ── Panel ── */
.jm-panel {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 18px rgba(0,0,0,.08);
    overflow: hidden;
    margin-bottom: 24px;
}
.jm-panel-header {
    background: linear-gradient(135deg, #071a38, #114c8d);
    padding: 16px 22px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.jm-panel-header-title {
    color: #fff;
    font-size: 15px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 9px;
}
.jm-panel-body { padding: 22px; }

/* ── Info table ── */
.jm-info-table { width: 100%; border-collapse: collapse; }
.jm-info-table tr { border-bottom: 1px solid #f1f4fb; }
.jm-info-table tr:last-child { border-bottom: none; }
.jm-info-table td { padding: 11px 6px; font-size: 14px; vertical-align: middle; }
.jm-info-label {
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: #6b7280;
    white-space: nowrap;
    width: 110px;
    display: flex;
    align-items: center;
    gap: 7px;
}
.jm-info-value { color: #1f2937; font-weight: 500; }

/* ── Avatar grande ── */
.jm-cliente-avatar {
    width: 64px;
    height: 64px;
    border-radius: 18px;
    background: linear-gradient(135deg, #071a38, #2f6df6);
    color: #fff;
    font-size: 24px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    text-transform: uppercase;
    flex-shrink: 0;
    margin-bottom: 16px;
}

/* ── Motos list ── */
.jm-moto-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 16px;
    border-bottom: 1px solid #f1f4fb;
    transition: background .15s;
}
.jm-moto-item:last-child { border-bottom: none; }
.jm-moto-item:hover { background: #f6f9ff; }
.jm-moto-nombre { font-weight: 700; color: #0b2f5b; font-size: 14px; }
.jm-moto-placa  { font-size: 12px; color: #6b7280; margin-top: 2px; }
.jm-moto-badge  {
    background: #eaf1ff;
    color: #1a4db8;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 50px;
    white-space: nowrap;
}

/* ── Historial tabla ── */
.jm-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.jm-table thead tr { background: #f0f5ff; }
.jm-table thead th {
    padding: 11px 14px;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .6px;
    color: #0b2f5b;
    border-bottom: 2px solid #dde6ff;
    white-space: nowrap;
}
.jm-table tbody tr {
    border-bottom: 1px solid #f1f4fb;
    cursor: pointer;
    transition: background .15s;
}
.jm-table tbody tr:last-child { border-bottom: none; }
.jm-table tbody tr:hover { background: #f0f6ff; }
.jm-table tbody td { padding: 12px 14px; vertical-align: middle; color: #374151; }

/* ── Badges estado pago ── */
.jm-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 11px;
    border-radius: 50px;
    font-size: 11px;
    font-weight: 700;
}
.jm-badge-green  { background:#eaf9ef; color:#1a7a43; }
.jm-badge-orange { background:#fff5df; color:#92600a; }
.jm-badge-red    { background:#fef2f2; color:#b91c1c; }
.jm-badge-gray   { background:#f3f4f6; color:#4b5563; }
.jm-badge-navy   { background:#e8eef8; color:#0b2f5b; }

/* ── Botones ── */
.jm-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: box-shadow .2s, transform .15s;
    white-space: nowrap;
    font-family: inherit;
}
.jm-btn:hover { transform: translateY(-1px); }
.jm-btn-back {
    background: #fff;
    border: 1.5px solid #cbd5e1;
    color: #374151;
}
.jm-btn-back:hover { border-color:#0b2f5b; color:#0b2f5b; background:#f0f5ff; }
.jm-btn-lavado {
    background: linear-gradient(135deg, #1e8a4c, #27ae60);
    color: #fff;
    box-shadow: 0 4px 12px rgba(39,174,96,.28);
}
.jm-btn-lavado:hover { box-shadow: 0 6px 18px rgba(39,174,96,.40); color:#fff; }
.jm-btn-edit {
    background: linear-gradient(135deg, #7a4e00, #d6a531);
    color: #fff;
    box-shadow: 0 4px 12px rgba(214,165,49,.28);
}
.jm-btn-edit:hover { box-shadow: 0 6px 18px rgba(214,165,49,.40); color:#fff; }
.jm-btn-del {
    background: linear-gradient(135deg, #a01f1f, #e74c3c);
    color: #fff;
    box-shadow: 0 4px 12px rgba(231,76,60,.28);
}
.jm-btn-del:hover { box-shadow: 0 6px 18px rgba(231,76,60,.40); color:#fff; }
.jm-btn-sm { padding: 6px 13px; font-size: 12px; }
.jm-btn-agregar {
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.30);
    color: #fff;
    padding: 5px 13px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: background .2s;
}
.jm-btn-agregar:hover { background: rgba(255,255,255,.25); color:#fff; }

/* ── Empty state ── */
.jm-empty {
    text-align: center;
    padding: 48px 20px;
    color: #9ca3af;
}
.jm-empty i { font-size: 48px; display:block; margin-bottom:12px; opacity:.3; }

/* ── Responsive ── */
@media(max-width:768px) {
    .jm-stat-grid { grid-template-columns: repeat(2,1fr); }
    .jm-header { flex-direction:column; align-items:flex-start; gap:14px; padding:20px; }
}
</style>

<div class="container mt-4">

    {{-- ══ HEADER ══ --}}
    <div class="jm-header mb-4">
        <div class="jm-header-left">
            <img src="{{ asset('images/logoM.png') }}"
                 style="width:72px;height:72px;object-fit:contain;">
            <div>
                <div class="jm-header-title">SISTEMA JM</div>
                <div class="jm-header-subtitle">Panel de control</div>
            </div>
        </div>
        <div class="jm-header-right">
            <span class="jm-header-module">
                <i class="bi bi-person-lines-fill me-1"></i> Detalle de Cliente
            </span>
            <div class="jm-date">
                {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM YYYY') }}
            </div>
        </div>
    </div>

    {{-- ══ BARRA ACCIONES ══ --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('clientes.index') }}" class="jm-btn jm-btn-back">
                <i class="bi bi-arrow-left-short" style="font-size:18px"></i> Volver
            </a>
            <div>
                <h5 class="mb-0 fw-bold" style="color:#0b2f5b;">
                    <i class="bi bi-person-fill me-1"></i> {{ $cliente->nombre }}
                </h5>
                <small style="color:#6b7280;">ID #{{ $cliente->id }} · Registrado el {{ $cliente->created_at?->format('d/m/Y') }}</small>
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('lavados.create') }}?cliente_id={{ $cliente->id }}"
               class="jm-btn jm-btn-lavado">
                <i class="bi bi-plus-lg"></i> Nuevo Lavado
            </a>
            <a href="{{ route('clientes.edit', $cliente->id) }}"
               class="jm-btn jm-btn-edit">
                <i class="bi bi-pencil-fill"></i> Editar
            </a>
            <form action="{{ route('clientes.destroy', $cliente->id) }}"
                  method="POST" class="form-eliminar m-0">
                @csrf
                @method('DELETE')
                <button type="submit" class="jm-btn jm-btn-del">
                    <i class="bi bi-trash-fill"></i> Eliminar
                </button>
            </form>
        </div>
    </div>

    {{-- ══ STAT CARDS ══ --}}
    <div class="jm-stat-grid">

        <div class="jm-stat jm-stat-blue">
            <div class="jm-stat-label">
                <i class="bi bi-droplet-fill" style="color:#2f6df6"></i> Total Lavados
            </div>
            <div class="jm-stat-value">{{ $totalLavados }}</div>
        </div>

        <div class="jm-stat jm-stat-green">
            <div class="jm-stat-label">
                <i class="bi bi-cash-stack" style="color:#27ae60"></i> Total Gastado
            </div>
            <div class="jm-stat-value">Bs. {{ number_format($totalGastado, 2) }}</div>
        </div>

        <div class="jm-stat jm-stat-teal">
            <div class="jm-stat-label">
                <i class="bi bi-check-circle-fill" style="color:#29c5d8"></i> Total Pagado
            </div>
            <div class="jm-stat-value">Bs. {{ number_format($totalPagado, 2) }}</div>
        </div>

        <div class="jm-stat {{ $saldoPendiente > 0 ? 'jm-stat-red' : 'jm-stat-green' }}">
            <div class="jm-stat-label">
                <i class="bi bi-exclamation-triangle-fill"
                   style="color:{{ $saldoPendiente > 0 ? '#e74c3c' : '#27ae60' }}"></i>
                Saldo Pendiente
            </div>
            <div class="jm-stat-value {{ $saldoPendiente > 0 ? 'text-danger' : 'text-success' }}">
                Bs. {{ number_format($saldoPendiente, 2) }}
            </div>
        </div>

    </div>

    <div class="row g-4">

        {{-- ══ COLUMNA IZQUIERDA ══ --}}
        <div class="col-md-4">

            {{-- Info del cliente --}}
            <div class="jm-panel">
                <div class="jm-panel-header">
                    <div class="jm-panel-header-title">
                        <i class="bi bi-person-fill"></i> Información del cliente
                    </div>
                </div>
                <div class="jm-panel-body">

                    <div class="jm-cliente-avatar">
                        {{ strtoupper(substr($cliente->nombre, 0, 2)) }}
                    </div>

                    <table class="jm-info-table">
                        <tr>
                            <td>
                                <div class="jm-info-label">
                                    <i class="bi bi-person-vcard" style="color:#7c3aed"></i> CI
                                </div>
                            </td>
                            <td class="jm-info-value">{{ $cliente->ci }}</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="jm-info-label">
                                    <i class="bi bi-telephone-fill" style="color:#27ae60"></i> Teléfono
                                </div>
                            </td>
                            <td class="jm-info-value">{{ $cliente->telefono ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="jm-info-label">
                                    <i class="bi bi-geo-alt-fill" style="color:#d6a531"></i> Dirección
                                </div>
                            </td>
                            <td class="jm-info-value">{{ $cliente->direccion ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="jm-info-label">
                                    <i class="bi bi-calendar-check" style="color:#2f6df6"></i> Registro
                                </div>
                            </td>
                            <td class="jm-info-value">{{ $cliente->created_at?->format('d/m/Y') ?? '—' }}</td>
                        </tr>
                        @if($ultimaVisita && $ultimaVisita->fecha)
                        <tr>
                            <td>
                                <div class="jm-info-label">
                                    <i class="bi bi-clock-history" style="color:#29c5d8"></i> Última visita
                                </div>
                            </td>
                            <td class="jm-info-value">{{ $ultimaVisita->fecha->format('d/m/Y') }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            {{-- Motos --}}
            <div class="jm-panel">
                <div class="jm-panel-header">
                    <div class="jm-panel-header-title">
                        <i class="bi bi-bicycle"></i>
                        Motos ({{ $cliente->motos->count() }})
                    </div>
                    <a href="{{ route('motos.create') }}?cliente_id={{ $cliente->id }}"
                       class="jm-btn-agregar">
                        <i class="bi bi-plus-lg"></i> Agregar
                    </a>
                </div>

                @if($cliente->motos->count() > 0)
                    @foreach($cliente->motos as $moto)
                        <div class="jm-moto-item">
                            <div>
                                <div class="jm-moto-nombre">
                                    <i class="bi bi-bicycle me-1" style="color:#2f6df6"></i>
                                    {{ $moto->marca }} {{ $moto->modelo }}
                                </div>
                                <div class="jm-moto-placa">
                                    <i class="bi bi-tag me-1"></i>{{ $moto->placa }}
                                </div>
                            </div>
                            <span class="jm-moto-badge">
                                {{ $moto->lavados->count() }} lavados
                            </span>
                        </div>
                    @endforeach
                @else
                    <div class="jm-empty" style="padding:32px 20px;">
                        <i class="bi bi-bicycle" style="font-size:36px;display:block;margin-bottom:10px;opacity:.3;"></i>
                        <small>No hay motos registradas</small>
                    </div>
                @endif
            </div>

        </div>

        {{-- ══ COLUMNA DERECHA — Historial ══ --}}
        <div class="col-md-8">
            <div class="jm-panel">
                <div class="jm-panel-header">
                    <div class="jm-panel-header-title">
                        <i class="bi bi-clock-history"></i> Historial de lavados
                    </div>
                    <span style="background:rgba(255,255,255,.18);border:1px solid rgba(255,255,255,.28);color:#fff;font-size:12px;font-weight:700;padding:4px 14px;border-radius:50px;">
                        {{ $cliente->lavados->count() }} registros
                    </span>
                </div>

                @if($cliente->lavados->count() > 0)
                    <div class="table-responsive">
                        <table class="jm-table">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Moto</th>
                                    <th>Servicio</th>
                                    <th>Trabajador</th>
                                    <th>Total</th>
                                    <th>Pago</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cliente->lavados->sortByDesc('fecha') as $lavado)
                                    <tr onclick="window.location='{{ route('lavados.show', $lavado->id_orden) }}'">

                                        <td>
                                            <span style="font-weight:600;color:#0b2f5b;">
                                                {{ $lavado->fecha->format('d/m/Y') }}
                                            </span>
                                        </td>

                                        <td>
                                            <div style="font-weight:700;color:#1f2937;font-size:13px;">
                                                {{ $lavado->moto->marca }} {{ $lavado->moto->modelo }}
                                            </div>
                                            <small style="color:#6b7280;">{{ $lavado->moto->placa }}</small>
                                        </td>

                                        <td>{{ $lavado->servicio->nombre ?? '—' }}</td>

                                        <td>
                                            <div style="display:flex;align-items:center;gap:7px;">
                                                <div style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#0b2f5b,#2f6df6);color:#fff;font-size:10px;font-weight:800;display:flex;align-items:center;justify-content:center;text-transform:uppercase;flex-shrink:0;">
                                                    {{ strtoupper(substr($lavado->trabajador->nombre ?? 'NA', 0, 2)) }}
                                                </div>
                                                {{ $lavado->trabajador->nombre ?? '—' }}
                                            </div>
                                        </td>

                                        <td>
                                            <span style="font-weight:800;color:#0b2f5b;">
                                                Bs. {{ number_format($lavado->precio_total, 2) }}
                                            </span>
                                        </td>

                                        <td>
                                            @if($lavado->estado_pago == 'pagado')
                                                <span class="jm-badge jm-badge-green">
                                                    <i class="bi bi-check-circle-fill"></i> Pagado
                                                </span>
                                            @elseif($lavado->estado_pago == 'parcial')
                                                <span class="jm-badge jm-badge-orange">
                                                    <i class="bi bi-clock-fill"></i> Parcial
                                                </span>
                                            @else
                                                <span class="jm-badge jm-badge-red">
                                                    <i class="bi bi-x-circle-fill"></i> Pendiente
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            <span class="jm-badge jm-badge-navy">
                                                {{ ucfirst($lavado->estado) }}
                                            </span>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="jm-empty">
                        <i class="bi bi-inbox"></i>
                        No hay lavados registrados para este cliente
                    </div>
                @endif

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
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    });
});
</script>
@endpush

@endsection