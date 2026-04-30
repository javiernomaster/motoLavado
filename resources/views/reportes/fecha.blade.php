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
}
.jm-header-title  { font-size:20px; font-weight:800; }
.jm-header-subtitle { font-size:13px; opacity:.8; }
.jm-header-module {
    background:rgba(255,255,255,.15);
    padding:5px 14px; border-radius:50px; font-size:13px;
}
.jm-date { font-size:13px; opacity:.85; margin-top:5px; }

/* ── CALENDARIO ───────────────────────────────────────── */
.calendario-card {
    background: #fff;
    border: 0;
    border-radius: 18px;
    box-shadow: 0 8px 32px rgba(7,26,56,.12);
    overflow: hidden;
    margin-bottom: 28px;
}
.calendario-header {
    background: linear-gradient(135deg, #071a38, #114c8d);
    color: #fff;
    padding: 16px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}
.calendario-body { padding: 24px; }

.input-calendario-wrapper {
    position: relative;
    max-width: 280px;
}
.input-calendario {
    width: 100%;
    padding: 14px 20px;
    padding-right: 50px;
    border: 2px solid #dee2e6;
    border-radius: 50px;
    font-size: 15px;
    font-weight: 600;
    outline: none;
    transition: border-color .2s;
    cursor: pointer;
}
.input-calendario:focus { border-color: #114c8d; }
.icono-calendario {
    position: absolute;
    right: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    pointer-events: none;
    font-size: 20px;
}

/* ── RESULTADOS ───────────────────────────────────────── */
.resultados-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    padding: 16px 24px;
    background: #f8f9fc;
    border-bottom: 1px solid #e9ecef;
}
.resultados-titulo {
    font-weight: 800;
    font-size: 15px;
    color: #0b2f5b;
}
.resultados-meta {
    display: flex;
    gap: 16px;
    align-items: center;
}
.resultados-count {
    font-size: 13px;
    color: #6c757d;
}
.resultados-total {
    font-weight: 800;
    font-size: 18px;
    color: #198754;
}

.tabla-resultados {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
.tabla-resultados thead th {
    background: #f1f3f8;
    padding: 12px 16px;
    text-align: center;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: #495057;
    border-bottom: 2px solid #dee2e6;
    white-space: nowrap;
}
.tabla-resultados tbody td {
    padding: 12px 16px;
    text-align: center;
    border-bottom: 1px solid #f0f0f0;
    vertical-align: middle;
}
.tabla-resultados tbody tr:hover { background: #f8f9fc; }
.tabla-resultados tbody tr:last-child td { border-bottom: none; }

.sin-resultados {
    text-align: center;
    padding: 48px;
    color: #adb5bd;
}
.sin-resultados i { font-size: 3rem; opacity: .5; }

/* ── LOADING ───────────────────────────────────────── */
.loading-spinner {
    text-align: center;
    padding: 48px;
    color: #6c757d;
}
.jm-spinner {
    width: 36px;
    height: 36px;
    border: 4px solid #dee2e6;
    border-top-color: #0b2f5b;
    border-radius: 50%;
    animation: spin .7s linear infinite;
    margin: 0 auto 12px;
}
@keyframes spin { to { transform: rotate(360deg); } }

.badge-pill {
    padding: 5px 12px;
    border-radius: 50px;
    font-size: 11px;
    font-weight: 600;
}
</style>

<div class="container mt-4">

    <!-- HEADER -->
    <div class="jm-header">
        <div>
            <div class="jm-header-module">📅 Reporte por Fecha</div>
            <div class="jm-date">{{ now()->locale('es')->isoFormat('dddd, D [de] MMMM YYYY') }}</div>
        </div>
    </div>

    {{-- CALENDARIO --}}
    <div class="calendario-card">
        <div class="calendario-header">
            <span style="font-weight:800;font-size:16px;">📆 Seleccionar Fecha</span>
        </div>
        <div class="calendario-body">
            <div class="input-calendario-wrapper">
                <input 
                    type="date" 
                    id="inputFecha" 
                    class="input-calendario" 
                    value="{{ $fecha->format('Y-m-d') ?? now()->format('Y-m-d') }}"
                    max="{{ now()->format('Y-m-d') }}"
                    onchange="buscarPorFecha(this.value)"
                >
                <span class="icono-calendario">📅</span>
            </div>
        </div>
    </div>

    {{-- RESULTADOS --}}
    <div class="calendario-card" id="cardResultados" style="{{ $ordenes->isEmpty() ? 'display:none;' : '' }}">
        <div class="resultados-header">
            <span class="resultados-titulo" id="resultadosTitulo">
                📅 {{ $fecha->locale('es')->isoFormat('dddd, D [de] MMMM YYYY') }}
            </span>
            <div class="resultados-meta">
                <span class="resultados-count" id="resultadosCount">
                    {{ $ordenes->count() }} servicios
                </span>
                <span class="resultados-total" id="resultadosTotal">
                    Bs {{ number_format($total ?? 0, 2) }}
                </span>
            </div>
        </div>

        <div id="contenidoResultados">
            @if($ordenes->isEmpty())
                <div class="sin-resultados">
                    <i class="bi bi-calendar-x"></i>
                    <p class="mt-3 mb-0">No hay servicios registrados en esta fecha</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="tabla-resultados">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Hora</th>
                                <th>Cliente</th>
                                <th>Moto / Placa</th>
                                <th>Servicio</th>
                                <th>Trabajador</th>
                                <th>Precio</th>
                                <th>Método</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ordenes as $o)
                            <tr>
                                <td class="fw-semibold">#{{ $o->id_orden }}</td>
                                <td>{{ $o->fecha ? $o->fecha->format('H:i') : '—' }}</td>
                                <td>{{ $o->cliente?->nombre ?? '—' }}</td>
                                <td>
                                    {{ $o->moto?->marca ?? '' }} {{ $o->moto?->modelo ?? '' }}
                                    <br><small class="text-muted">{{ $o->moto?->placa ?? '' }}</small>
                                </td>
                                <td>{{ $o->servicio?->nombre ?? '—' }}</td>
                                <td>{{ $o->trabajador?->nombre ?? '—' }}</td>
                                <td class="fw-bold text-success">Bs {{ number_format($o->precio_total, 2) }}</td>
                                <td>
                                    <span class="badge-pill {{ badgeMetodo($o->metodo_pago) }}">
                                        {{ $o->metodo_pago ?? '—' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-pill {{ badgeEstado($o->estado_pago) }}">
                                        {{ $o->estado_pago ?? '—' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    {{-- LOADING --}}
    <div class="loading-spinner" id="loadingSpinner" style="display:none;">
        <div class="jm-spinner"></div>
        <p>Buscando registros...</p>
    </div>

    {{-- SIN RESULTADOS --}}
    <div class="calendario-card" id="cardSinResultados" style="{{ $ordenes->isEmpty() ? '' : 'display:none;' }}">
        <div class="sin-resultados">
            <i class="bi bi-calendar-x"></i>
            <p class="mt-3 mb-0">Selecciona una fecha para ver los registros</p>
        </div>
    </div>

</div>

<script>
function buscarPorFecha(fecha) {
    if (!fecha) return;

    const cardResultados = document.getElementById('cardResultados');
    const cardSinResultados = document.getElementById('cardSinResultados');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const contenido = document.getElementById('contenidoResultados');

    // Mostrar loading
    cardResultados.style.display = 'none';
    cardSinResultados.style.display = 'none';
    loadingSpinner.style.display = 'block';

    fetch('{{ route("reportes.fecha.ajax") }}?fecha=' + fecha, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(r => r.json())
    .then(data => {
        loadingSpinner.style.display = 'none';

        // Actualizar encabezado
        document.getElementById('resultadosTitulo').textContent = '📅 ' + data.fecha;
        document.getElementById('resultadosCount').textContent = data.count + ' servicios';
        document.getElementById('resultadosTotal').textContent = 'Bs ' + data.total;

        if (data.count === 0) {
            cardSinResultados.style.display = 'block';
            return;
        }

        // Generar filas de la tabla
        const filas = data.ordenes.map(o => `
            <tr>
                <td class="fw-semibold">#${o.id_orden}</td>
                <td>${o.hora}</td>
                <td>${o.cliente}</td>
                <td>${o.moto}<br><small class="text-muted">${o.placa}</small></td>
                <td>${o.servicio}</td>
                <td>${o.trabajador}</td>
                <td class="fw-bold text-success">Bs ${o.precio}</td>
                <td><span class="badge-pill ${badgeMetodo(o.metodo_pago)}">${o.metodo_pago}</span></td>
                <td><span class="badge-pill ${badgeEstado(o.estado_pago)}">${o.estado_pago}</span></td>
            </tr>
        `).join('');

        contenido.innerHTML = `
            <div class="table-responsive">
                <table class="tabla-resultados">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Hora</th>
                            <th>Cliente</th>
                            <th>Moto / Placa</th>
                            <th>Servicio</th>
                            <th>Trabajador</th>
                            <th>Precio</th>
                            <th>Método</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>${filas}</tbody>
                </table>
            </div>`;

        cardResultados.style.display = 'block';
    })
    .catch(err => {
        loadingSpinner.style.display = 'none';
        cardSinResultados.style.display = 'block';
        console.error(err);
    });
}

function badgeMetodo(metodo) {
    const m = (metodo || '').toLowerCase();
    if (m.includes('efectivo')) return 'bg-success text-white';
    if (m.includes('qr') || m.includes('transfer')) return 'bg-info text-dark';
    return 'bg-secondary text-white';
}

function badgeEstado(estado) {
    const e = (estado || '').toLowerCase();
    if (e.includes('pagado') || e.includes('completo')) return 'bg-success text-white';
    if (e.includes('pendiente')) return 'bg-warning text-dark';
    if (e.includes('parcial')) return 'bg-info text-dark';
    return 'bg-secondary text-white';
}
</script>

@endsection
