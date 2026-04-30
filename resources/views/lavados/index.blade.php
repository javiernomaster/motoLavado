@extends('layouts.app')

@section('content')

<style>
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

.jm-search-box {
    background: #fff;
    border-radius: 14px;
    padding: 18px 22px;
    box-shadow: 0 4px 16px rgba(0,0,0,.07);
    margin-bottom: 20px;
}
.jm-search-box .form-control {
    border: 1.5px solid #dde3ef;
    border-radius: 10px;
    padding: 10px 16px;
    font-size: 14px;
}
.jm-search-box .form-control:focus {
    border-color: #114c8d;
    box-shadow: 0 0 0 3px rgba(17,76,141,.12);
    outline: none;
}
.jm-btn-search {
    background: linear-gradient(135deg, #0b2f5b, #114c8d);
    color: #fff; border: none; border-radius: 10px;
    padding: 10px 22px; font-weight: 600; font-size: 14px; cursor: pointer;
}
.jm-table-wrap {
    background: #fff; border-radius: 18px;
    box-shadow: 0 6px 24px rgba(0,0,0,.09); overflow: hidden;
}
.jm-table-header {
    background: linear-gradient(135deg, #071a38, #114c8d);
    padding: 18px 26px; display:flex; align-items:center; justify-content:space-between;
}
.jm-table-header-title { color:#fff; font-size:16px; font-weight:700; display:flex; align-items:center; gap:9px; }
.jm-total-badge {
    background: rgba(255,255,255,.18); border: 1px solid rgba(255,255,255,.28);
    color: #fff; font-size: 12px; font-weight: 700; padding: 4px 14px; border-radius: 50px;
}
.jm-table { width:100%; border-collapse:collapse; font-size:14px; }
.jm-table thead tr { background:#f0f5ff; }
.jm-table thead th {
    padding: 13px 16px; font-size: 11px; font-weight: 800;
    text-transform: uppercase; letter-spacing: .7px;
    color: #0b2f5b; border-bottom: 2px solid #dde6ff; white-space: nowrap;
}
.jm-table tbody tr { border-bottom: 1px solid #f1f4fb; transition: background .15s; }
.jm-table tbody tr:last-child { border-bottom: none; }
.jm-table tbody tr:hover { background: #f6f9ff; }
.jm-table tbody td { padding: 14px 16px; vertical-align: middle; color: #374151; font-size: 14px; }

.jm-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 12px; border-radius: 50px; font-size: 12px; font-weight: 700;
}
.jm-badge-id     { background:#eef0f7; color:#4b5563; }
.jm-badge-pend   { background:#fff3cd; color:#856404; }
.jm-badge-proc   { background:#cfe2ff; color:#084298; }
.jm-badge-fin    { background:#d1e7dd; color:#0a3622; }
.jm-badge-pagado { background:#d1e7dd; color:#0a3622; }
.jm-badge-parcial{ background:#fff3cd; color:#856404; }
.jm-badge-nopag  { background:#f8d7da; color:#842029; }

.jm-avatar {
    width:36px; height:36px; border-radius:50%;
    background: linear-gradient(135deg, #0b2f5b, #2f6df6);
    color:#fff; font-size:13px; font-weight:800;
    display:inline-flex; align-items:center; justify-content:center;
    flex-shrink:0; text-transform:uppercase;
}
.jm-nombre-wrap { display:flex; align-items:center; gap:10px; }
.jm-nombre-text { font-weight:700; color:#0b2f5b; font-size:14px; }

.jm-btn-ver {
    background: linear-gradient(135deg,#0e3d74,#29c5d8); color:#fff !important;
    border:none; border-radius:9px; padding:7px 14px; font-size:12px; font-weight:700;
    text-decoration:none; display:inline-flex; align-items:center; gap:5px; white-space:nowrap;
}
.jm-btn-edit {
    background: linear-gradient(135deg,#7a4e00,#d6a531); color:#fff !important;
    border:none; border-radius:9px; padding:7px 14px; font-size:12px; font-weight:700;
    text-decoration:none; display:inline-flex; align-items:center; gap:5px; white-space:nowrap;
}
.jm-btn-del {
    background: linear-gradient(135deg,#a01f1f,#e74c3c); color:#fff !important;
    border:none; border-radius:9px; padding:7px 14px; font-size:12px; font-weight:700;
    cursor:pointer; display:inline-flex; align-items:center; gap:5px;
    white-space:nowrap; font-family:inherit;
}
.jm-btn-cobrar {
    background: linear-gradient(135deg,#145a32,#27ae60); color:#fff !important;
    border:none; border-radius:9px; padding:7px 14px; font-size:12px; font-weight:700;
    text-decoration:none; display:inline-flex; align-items:center; gap:5px; white-space:nowrap;
}
.jm-empty { text-align:center; padding:56px 20px; color:#9ca3af; }
.jm-empty i { font-size:52px; display:block; margin-bottom:12px; opacity:.3; }
.jm-pag-wrap { padding:18px 24px; border-top:1px solid #f1f4fb; }
.jm-counter { font-size:13px; color:#6b7280; margin-bottom:14px; }

.jm-totales {
    display: flex; gap: 16px; flex-wrap: wrap; margin-bottom: 20px;
}
.jm-total-card {
    background: #fff; border-radius: 14px; padding: 16px 22px;
    box-shadow: 0 4px 16px rgba(0,0,0,.07); flex: 1; min-width: 160px;
}
.jm-total-card .label { font-size: 12px; color: #6b7280; font-weight: 600; margin-bottom: 4px; }
.jm-total-card .value { font-size: 20px; font-weight: 800; color: #0b2f5b; }
</style>

<div class="container mt-4">

    {{-- HEADER --}}
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
                <i class="bi bi-droplet-fill me-1"></i> Módulo Lavados
            </span>
            <div class="jm-date">
                {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM YYYY') }}
            </div>
        </div>
    </div>

    {{-- BARRA ACCIONES --}}
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-short" style="font-size:18px"></i> Volver
            </a>
            <h5 class="mb-0 fw-bold" style="color:#0b2f5b;">
                <i class="bi bi-droplet-fill me-1"></i> Lavados
            </h5>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('lavados.papelera') }}" class="btn btn-outline-secondary">
                <i class="bi bi-trash3"></i> Papelera
            </a>
            <a href="{{ route('lavados.create') }}"
               style="background:linear-gradient(135deg,#0b2f5b,#114c8d);color:#fff;border:none;border-radius:9px;padding:8px 18px;font-weight:700;font-size:14px;text-decoration:none;display:inline-flex;align-items:center;gap:6px;box-shadow:0 4px 14px rgba(17,76,141,.30);">
                <i class="bi bi-plus-lg"></i> Nuevo Lavado
            </a>
        </div>
    </div>

    {{-- FLASH --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show">
            <i class="bi bi-info-circle-fill me-2"></i>{{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- TOTALES --}}
    <div class="jm-totales">
        <div class="jm-total-card">
            <div class="label"><i class="bi bi-list-check me-1"></i> Lavados filtrados</div>
            <div class="value">{{ $cantidadFiltrada }}</div>
        </div>
        <div class="jm-total-card">
            <div class="label"><i class="bi bi-cash-stack me-1"></i> Total a cobrar</div>
            <div class="value" style="color:#0a3622;">Bs. {{ number_format($totalFiltrado, 2) }}</div>
        </div>
        <div class="jm-total-card">
            <div class="label"><i class="bi bi-check2-circle me-1"></i> Total pagado</div>
            <div class="value" style="color:#27ae60;">Bs. {{ number_format($totalPagado, 2) }}</div>
        </div>
        <div class="jm-total-card">
            <div class="label"><i class="bi bi-exclamation-circle me-1"></i> Saldo pendiente</div>
            <div class="value" style="color:#e74c3c;">Bs. {{ number_format($totalFiltrado - $totalPagado, 2) }}</div>
        </div>
    </div>

    {{-- BUSCADOR / FILTROS --}}
    <div class="jm-search-box">
        <form action="{{ route('lavados.index') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-600 mb-1" style="font-size:13px;">Cliente</label>
                <input type="text" name="cliente" value="{{ request('cliente') }}"
                       class="form-control" placeholder="Buscar por cliente...">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-600 mb-1" style="font-size:13px;">Estado</label>
                <select name="estado" class="form-control">
                    <option value="">Todos</option>
                    <option value="Pendiente"   {{ request('estado') == 'Pendiente'   ? 'selected' : '' }}>Pendiente</option>
                    <option value="En proceso"  {{ request('estado') == 'En proceso'  ? 'selected' : '' }}>En proceso</option>
                    <option value="Finalizado"  {{ request('estado') == 'Finalizado'  ? 'selected' : '' }}>Finalizado</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-600 mb-1" style="font-size:13px;">Desde</label>
                <input type="date" name="desde" value="{{ request('desde') }}" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-600 mb-1" style="font-size:13px;">Hasta</label>
                <input type="date" name="hasta" value="{{ request('hasta') }}" class="form-control">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="jm-btn-search w-100">
                    <i class="bi bi-search me-1"></i> Filtrar
                </button>
                @if(request()->anyFilled(['cliente','estado','desde','hasta']))
                    <a href="{{ route('lavados.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-x-lg"></i> Limpiar
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- CONTADOR --}}
    <div class="jm-counter">
        <i class="bi bi-info-circle me-1"></i>
        Mostrando <strong>{{ $lavados->firstItem() ?? 0 }}</strong> –
        <strong>{{ $lavados->lastItem() ?? 0 }}</strong> de
        <strong>{{ $cantidadFiltrada }}</strong> lavado(s)
    </div>

    {{-- TABLA --}}
    <div class="jm-table-wrap">

        <div class="jm-table-header">
            <div class="jm-table-header-title">
                <i class="bi bi-droplet-fill"></i> Registro de lavados
            </div>
            <span class="jm-total-badge">{{ $cantidadFiltrada }} en total</span>
        </div>

        <div class="table-responsive">
            <table class="jm-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Moto</th>
                        <th>Servicio</th>
                        <th>Trabajador</th>
                        <th>Total</th>
                        <th>Pagado</th>
                        <th>Saldo</th>
                        <th>Estado</th>
                        <th>Pago</th>
                        <th style="text-align:center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($lavados as $lavado)
                    <tr>
                        <td><span class="jm-badge jm-badge-id"># {{ $lavado->id_orden }}</span></td>

                        <td>{{ \Carbon\Carbon::parse($lavado->fecha)->format('d/m/Y') }}</td>

                        <td>
                            <div class="jm-nombre-wrap">
                                <div class="jm-avatar">
                                    {{ strtoupper(substr($lavado->cliente->nombre ?? '?', 0, 2)) }}
                                </div>
                                <span class="jm-nombre-text">{{ $lavado->cliente->nombre ?? '—' }}</span>
                            </div>
                        </td>

                        <td>{{ $lavado->moto->placa ?? '—' }}</td>

                        <td>{{ $lavado->servicio->nombre ?? '—' }}</td>

                        <td>{{ $lavado->trabajador->nombre ?? '—' }}</td>

                        <td><strong>Bs. {{ number_format($lavado->precio_total, 2) }}</strong></td>

                        <td style="color:#27ae60;font-weight:700;">
                            Bs. {{ number_format($lavado->monto_pagado, 2) }}
                        </td>

                        <td style="color:#e74c3c;font-weight:700;">
                            Bs. {{ number_format($lavado->saldo, 2) }}
                        </td>

                        <td>
                            @if($lavado->estado === 'Pendiente')
                                <span class="jm-badge jm-badge-pend">
                                    <i class="bi bi-clock"></i> Pendiente
                                </span>
                            @elseif($lavado->estado === 'En proceso')
                                <span class="jm-badge jm-badge-proc">
                                    <i class="bi bi-arrow-repeat"></i> En proceso
                                </span>
                            @else
                                <span class="jm-badge jm-badge-fin">
                                    <i class="bi bi-check-circle"></i> Finalizado
                                </span>
                            @endif
                        </td>

                        <td>
                            @if($lavado->estado_pago === 'pagado')
                                <span class="jm-badge jm-badge-pagado"><i class="bi bi-check2-all"></i> Pagado</span>
                            @elseif($lavado->estado_pago === 'parcial')
                                <span class="jm-badge jm-badge-parcial"><i class="bi bi-half"></i> Parcial</span>
                            @else
                                <span class="jm-badge jm-badge-nopag"><i class="bi bi-x-circle"></i> Pendiente</span>
                            @endif
                        </td>

                        <td style="text-align:center">
                            <div class="d-flex justify-content-center gap-2 flex-wrap">

                                <a href="{{ route('lavados.show', $lavado->id_orden) }}" class="jm-btn-ver">
                                    <i class="bi bi-eye-fill"></i> Ver
                                </a>

                                @if($lavado->estado !== 'Finalizado')
                                    <a href="{{ route('lavados.edit', $lavado->id_orden) }}" class="jm-btn-edit">
                                        <i class="bi bi-pencil-fill"></i> Editar
                                    </a>
                                @endif

                                @if($lavado->saldo > 0)
                                    <a href="{{ route('lavados.cobrar', $lavado->id_orden) }}" class="jm-btn-cobrar">
                                        <i class="bi bi-cash-coin"></i> Cobrar
                                    </a>
                                @endif

                                <form action="{{ route('lavados.destroy', $lavado->id_orden) }}"
                                      method="POST" class="form-eliminar m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="jm-btn-del">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12">
                            <div class="jm-empty">
                                <i class="bi bi-droplet"></i>
                                No hay lavados registrados
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($lavados->hasPages())
            <div class="jm-pag-wrap d-flex justify-content-center">
                {{ $lavados->links() }}
            </div>
        @endif

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.form-eliminar').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Eliminar lavado?',
                text: 'El lavado se moverá a la papelera.',
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

@endsection