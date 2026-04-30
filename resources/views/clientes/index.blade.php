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
.jm-header-left {
    display: flex;
    align-items: center;
    gap: 16px;
    position: relative;
}
.jm-header-title   { font-size: 20px; font-weight: 800; letter-spacing: .6px; }
.jm-header-subtitle{ font-size: 13px; opacity: .80; margin-top: 2px; }
.jm-header-module  {
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.25);
    padding: 5px 16px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 600;
    position: relative;
}
.jm-header-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 6px;
    position: relative;
}
.jm-date { font-size: 13px; opacity: .85; font-weight: 500; }

/* ── Buscador ── */
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
    transition: border-color .2s, box-shadow .2s;
}
.jm-search-box .form-control:focus {
    border-color: #114c8d;
    box-shadow: 0 0 0 3px rgba(17,76,141,.12);
    outline: none;
}
.jm-btn-search {
    background: linear-gradient(135deg, #0b2f5b, #114c8d);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 10px 22px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: box-shadow .2s;
}
.jm-btn-search:hover {
    box-shadow: 0 4px 14px rgba(17,76,141,.35);
}

/* ── Wrapper tabla ── */
.jm-table-wrap {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 6px 24px rgba(0,0,0,.09);
    overflow: hidden;
}

/* ── Cabecera de la tabla ── */
.jm-table-header {
    background: linear-gradient(135deg, #071a38, #114c8d);
    padding: 18px 26px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.jm-table-header-title {
    color: #fff;
    font-size: 16px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 9px;
}
.jm-total-badge {
    background: rgba(255,255,255,.18);
    border: 1px solid rgba(255,255,255,.28);
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    padding: 4px 14px;
    border-radius: 50px;
}

/* ── thead ── */
.jm-table { width: 100%; border-collapse: collapse; font-size: 14px; }
.jm-table thead tr { background: #f0f5ff; }
.jm-table thead th {
    padding: 13px 16px;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .7px;
    color: #0b2f5b;
    border-bottom: 2px solid #dde6ff;
    white-space: nowrap;
}

/* ── tbody ── */
.jm-table tbody tr {
    border-bottom: 1px solid #f1f4fb;
    transition: background .15s;
}
.jm-table tbody tr:last-child { border-bottom: none; }
.jm-table tbody tr:hover { background: #f6f9ff; }
.jm-table tbody td {
    padding: 14px 16px;
    vertical-align: middle;
    color: #374151;
    font-size: 14px;
}

/* ── Celda nombre con avatar ── */
.jm-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, #0b2f5b, #2f6df6);
    color: #fff;
    font-size: 13px;
    font-weight: 800;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    text-transform: uppercase;
}
.jm-nombre-wrap {
    display: flex;
    align-items: center;
    gap: 10px;
}
.jm-nombre-text {
    font-weight: 700;
    color: #0b2f5b;
    font-size: 14px;
}

/* ── Badges ── */
.jm-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 12px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 700;
}
.jm-badge-id     { background: #eef0f7; color: #4b5563; font-size: 12px; }
.jm-badge-moto   { background: #eaf1ff; color: #1a4db8; cursor: pointer; }
.jm-badge-sin    { background: #f3f4f6; color: #9ca3af; }

/* ── Íconos en celdas ── */
.jm-cell-icon { font-size: 13px; margin-right: 5px; }
.icon-phone   { color: #27ae60; }
.icon-loc     { color: #d6a531; }
.icon-ci      { color: #7c3aed; }

/* ── Botones de acción ── */
.jm-btn-ver {
    background: linear-gradient(135deg, #0e3d74, #29c5d8);
    color: #fff !important;
    border: none;
    border-radius: 9px;
    padding: 7px 14px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: box-shadow .2s, transform .15s;
    white-space: nowrap;
}
.jm-btn-ver:hover {
    box-shadow: 0 4px 12px rgba(41,197,216,.40);
    transform: translateY(-1px);
}
.jm-btn-edit {
    background: linear-gradient(135deg, #7a4e00, #d6a531);
    color: #fff !important;
    border: none;
    border-radius: 9px;
    padding: 7px 14px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: box-shadow .2s, transform .15s;
    white-space: nowrap;
}
.jm-btn-edit:hover {
    box-shadow: 0 4px 12px rgba(214,165,49,.40);
    transform: translateY(-1px);
}
.jm-btn-del {
    background: linear-gradient(135deg, #a01f1f, #e74c3c);
    color: #fff !important;
    border: none;
    border-radius: 9px;
    padding: 7px 14px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: box-shadow .2s, transform .15s;
    white-space: nowrap;
    font-family: inherit;
}
.jm-btn-del:hover {
    box-shadow: 0 4px 12px rgba(231,76,60,.40);
    transform: translateY(-1px);
}

/* ── Vacío ── */
.jm-empty {
    text-align: center;
    padding: 56px 20px;
    color: #9ca3af;
}
.jm-empty i { font-size: 52px; display: block; margin-bottom: 12px; opacity: .3; }

/* ── Paginación ── */
.jm-pag-wrap { padding: 18px 24px; border-top: 1px solid #f1f4fb; }

/* ── Contador ── */
.jm-counter {
    font-size: 13px;
    color: #6b7280;
    margin-bottom: 14px;
}

/* ── Tooltip motos ── */
#moto-tooltip {
    position: fixed;
    background: linear-gradient(135deg, #071a38, #0b2f5b);
    color: #fff;
    padding: 10px 16px;
    border-radius: 12px;
    font-size: 13px;
    line-height: 2;
    z-index: 9999;
    pointer-events: none;
    display: none;
    white-space: nowrap;
    box-shadow: 0 8px 24px rgba(0,0,0,.35);
    border: 1px solid rgba(255,255,255,.12);
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
                <i class="bi bi-people-fill me-1"></i> Módulo Clientes
            </span>
            <div class="jm-date">
                {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM YYYY') }}
            </div>
        </div>
    </div>

    {{-- ══ BARRA ACCIONES ══ --}}
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-short" style="font-size:18px"></i> Volver
            </a>
            <h5 class="mb-0 fw-bold" style="color:#0b2f5b;">
                <i class="bi bi-people-fill me-1"></i> Clientes
            </h5>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('clientes.papelera') }}" class="btn btn-outline-secondary">
                <i class="bi bi-trash3"></i> Papelera
            </a>
            <a href="{{ route('clientes.create') }}"
               style="background:linear-gradient(135deg,#0b2f5b,#114c8d);color:#fff;border:none;border-radius:9px;padding:8px 18px;font-weight:700;font-size:14px;text-decoration:none;display:inline-flex;align-items:center;gap:6px;box-shadow:0 4px 14px rgba(17,76,141,.30);">
                <i class="bi bi-plus-lg"></i> Nuevo Cliente
            </a>
        </div>
    </div>

    {{-- ══ FLASH ══ --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ══ BUSCADOR ══ --}}
    <div class="jm-search-box">
        <form action="{{ route('clientes.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-8">
                <input type="text" name="buscar" value="{{ request('buscar') }}"
                       class="form-control" placeholder="🔍  Buscar por nombre o CI...">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="jm-btn-search w-100">
                    <i class="bi bi-search me-1"></i> Buscar
                </button>
                @if(request('buscar'))
                    <a href="{{ route('clientes.index') }}"
                       class="btn btn-outline-secondary w-100">
                        <i class="bi bi-x-lg"></i> Limpiar
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- ══ CONTADOR ══ --}}
    <div class="jm-counter">
        <i class="bi bi-info-circle me-1"></i>
        Mostrando <strong>{{ $clientes->firstItem() ?? 0 }}</strong> –
        <strong>{{ $clientes->lastItem() ?? 0 }}</strong> de
        <strong>{{ $totalClientes }}</strong> cliente(s)
    </div>

    {{-- ══ TABLA ══ --}}
    <div class="jm-table-wrap">

        {{-- Cabecera azul ──────────────────── --}}
        <div class="jm-table-header">
            <div class="jm-table-header-title">
                <i class="bi bi-people-fill"></i> Clientes registrados
            </div>
            <span class="jm-total-badge">
                {{ $totalClientes }} en total
            </span>
        </div>

        {{-- Tabla ──────────────────────────── --}}
        <div class="table-responsive">
            <table class="jm-table">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>CI</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th style="text-align:center">Motos</th>
                        <th style="text-align:center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($clientes as $c)
                    <tr>

                        {{-- ID --}}
                        <td>
                            <span class="jm-badge jm-badge-id"># {{ $c->id }}</span>
                        </td>

                        {{-- Nombre con avatar --}}
                        <td>
                            <div class="jm-nombre-wrap">
                                <div class="jm-avatar">
                                    {{ strtoupper(substr($c->nombre, 0, 2)) }}
                                </div>
                                <span class="jm-nombre-text">{{ $c->nombre }}</span>
                            </div>
                        </td>

                        {{-- CI --}}
                        <td>
                            <i class="bi bi-person-vcard jm-cell-icon icon-ci"></i>
                            {{ $c->ci }}
                        </td>

                        {{-- Teléfono --}}
                        <td>
                            <i class="bi bi-telephone-fill jm-cell-icon icon-phone"></i>
                            {{ $c->telefono }}
                        </td>

                        {{-- Dirección --}}
                        <td>
                            <i class="bi bi-geo-alt-fill jm-cell-icon icon-loc"></i>
                            {{ $c->direccion }}
                        </td>

                        {{-- Motos --}}
                        <td style="text-align:center">
                            @if($c->motos->count() > 0)
                                <span class="jm-badge jm-badge-moto moto-badge"
                                      data-motos="{{ $c->motos->map(fn($m) => $m->marca . ' ' . $m->modelo . ' — ' . $m->placa)->join('|') }}">
                                    <i class="bi bi-bicycle"></i>
                                    {{ $c->motos->count() }}
                                </span>
                            @else
                                <span class="jm-badge jm-badge-sin">0</span>
                            @endif
                        </td>

                        {{-- Acciones --}}
                        <td style="text-align:center">
                            <div class="d-flex justify-content-center gap-2 flex-wrap">

                                <a href="{{ route('clientes.show', $c->id) }}" class="jm-btn-ver">
                                    <i class="bi bi-eye-fill"></i> Ver
                                </a>

                                <a href="{{ route('clientes.edit', $c->id) }}" class="jm-btn-edit">
                                    <i class="bi bi-pencil-fill"></i> Editar
                                </a>

                                <form action="{{ route('clientes.destroy', $c->id) }}"
                                      method="POST" class="form-eliminar m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="jm-btn-del">
                                        <i class="bi bi-trash-fill"></i> Eliminar
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="jm-empty">
                                <i class="bi bi-people"></i>
                                No hay clientes registrados
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>

        {{-- Paginación ──────────────────────── --}}
        @if($clientes->hasPages())
            <div class="jm-pag-wrap d-flex justify-content-center">
                {{ $clientes->links() }}
            </div>
        @endif

    </div>

</div>

{{-- Tooltip motos --}}
<div id="moto-tooltip"></div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const tip = document.getElementById('moto-tooltip');

    document.querySelectorAll('.moto-badge').forEach(badge => {
        badge.addEventListener('mouseenter', function () {
            const motos = this.dataset.motos.split('|');
            tip.innerHTML = motos.map(m => '🏍 ' + m).join('<br>');
            tip.style.display = 'block';
        });
        badge.addEventListener('mousemove', function (e) {
            tip.style.left = (e.clientX + 14) + 'px';
            tip.style.top  = (e.clientY + 14) + 'px';
        });
        badge.addEventListener('mouseleave', function () {
            tip.style.display = 'none';
        });
    });

    document.querySelectorAll('.form-eliminar').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Eliminar cliente?',
                text: 'El cliente se moverá a la papelera.',
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