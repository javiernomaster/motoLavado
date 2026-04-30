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
    justify-content: space-between;
    align-items: center;
}
.jm-header-left   { display:flex; align-items:center; gap:16px; }
.jm-header-title  { font-size:20px; font-weight:800; }
.jm-header-subtitle { font-size:13px; opacity:.8; }
.jm-header-module {
    background:rgba(255,255,255,.15);
    padding:5px 14px; border-radius:50px; font-size:13px;
}
.jm-date { font-size:13px; opacity:.85; margin-top:5px; }

.btn-registro-jm {
    background: linear-gradient(135deg, #1a6b3a, #28a745);
    color: #fff;
    border: none;
    padding: 10px 24px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 14px;
    box-shadow: 0 4px 15px rgba(40,167,69,.35);
    transition: all .25s;
    cursor: pointer;
}
.btn-registro-jm:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(40,167,69,.45);
    color: #fff;
}
.btn-registro-jm.activo {
    background: linear-gradient(135deg, #0b2f5b, #114c8d);
    box-shadow: 0 4px 15px rgba(17,76,141,.40);
}

#panelRegistroJM { display:none; margin-bottom:28px; animation: slideDown .3s ease; }
#panelRegistroJM.show { display:block; }
@keyframes slideDown {
    from { opacity:0; transform:translateY(-12px); }
    to   { opacity:1; transform:translateY(0); }
}

.registro-panel-card { border:0; border-radius:18px; box-shadow:0 8px 32px rgba(7,26,56,.15); overflow:hidden; }

.registro-panel-header {
    background: linear-gradient(135deg, #071a38, #114c8d);
    color: #fff;
    padding: 16px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}

.periodo-tabs { display:flex; gap:8px; }
.periodo-tab {
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.25);
    color: #fff;
    padding: 6px 18px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s;
}
.periodo-tab:hover { background:rgba(255,255,255,.28); }
.periodo-tab.active { background:#fff; color:#0b2f5b; border-color:#fff; }

.export-btns { display:flex; gap:8px; flex-wrap:wrap; }
.btn-exp {
    padding: 6px 16px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    border: none;
    transition: all .2s;
}
.btn-exp-pdf  { background:#dc3545; color:#fff; }
.btn-exp-word { background:#2b579a; color:#fff; }
.btn-exp:hover { opacity:.85; transform:translateY(-1px); }

.registro-resumen {
    display:flex; gap:16px; padding:16px 24px;
    background:#f8f9fc; border-bottom:1px solid #e9ecef; flex-wrap:wrap;
}
.resumen-item { display:flex; flex-direction:column; }
.resumen-label { font-size:11px; color:#6c757d; text-transform:uppercase; letter-spacing:.5px; }
.resumen-valor { font-size:20px; font-weight:800; color:#0b2f5b; }
.resumen-valor.verde { color:#198754; }

.jm-loading { text-align:center; padding:48px; color:#6c757d; }
.jm-spinner {
    width:36px; height:36px;
    border:4px solid #dee2e6;
    border-top-color:#0b2f5b;
    border-radius:50%;
    animation:spin .7s linear infinite;
    margin:0 auto 12px;
}
@keyframes spin { to { transform:rotate(360deg); } }

.tabla-registros { width:100%; border-collapse:collapse; font-size:13px; }
.tabla-registros thead th {
    background:#f1f3f8; padding:10px 14px; text-align:center;
    font-size:11px; text-transform:uppercase; letter-spacing:.5px;
    color:#495057; border-bottom:2px solid #dee2e6; white-space:nowrap;
}
.tabla-registros tbody td {
    padding:10px 14px; text-align:center;
    border-bottom:1px solid #f0f0f0; vertical-align:middle;
}
.tabla-registros tbody tr:hover { background:#f8f9fc; }
.tabla-registros tbody tr:last-child td { border-bottom:none; }

.badge-pill-sm {
    padding:4px 10px; border-radius:50px; font-size:11px; font-weight:600;
}
.sin-datos { text-align:center; padding:48px; color:#adb5bd; }
</style>

<div class="container mt-4">

    {{-- HEADER --}}
    <div class="jm-header">
        <div class="jm-header-left">
            <img src="{{ asset('images/logoM.png') }}" style="width:60px;height:60px;object-fit:contain;">
            <div>
                <div class="jm-header-title">SISTEMA JM</div>
                <div class="jm-header-subtitle">Panel de control</div>
            </div>
        </div>
        <div class="text-end">
            <div class="jm-header-module">📊 Reporte de Trabajadores</div>
            <div class="jm-date">{{ now()->locale('es')->isoFormat('dddd, D [de] MMMM YYYY') }}</div>
        </div>
    </div>

    {{-- FILA SUPERIOR --}}
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h6 class="text-muted mb-0">Resumen del día</h6>
        <button class="btn-registro-jm" id="btnRegistroJM" onclick="toggleRegistroJM()">
            📋 Registro JM
        </button>
    </div>

    {{-- TARJETAS --}}
    <div class="row mb-4">
        <div class="col-md-3 col-6 mb-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h6 class="text-muted">Servicios Hoy</h6>
                    <h3 class="fw-bold text-primary">{{ $totalServicios ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h6 class="text-muted">Ganancia Trabajadores</h6>
                    <h3 class="fw-bold text-success">Bs. {{ number_format($gananciaTrabajadores ?? 0, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h6 class="text-muted">Ganancia Sistema JM</h6>
                    <h3 class="fw-bold text-warning">Bs. {{ number_format($gananciaSistema ?? 0, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h6 class="text-muted">Trabajadores Activos</h6>
                    <h3 class="fw-bold text-dark">{{ $trabajadores->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- PANEL REGISTRO JM --}}
    <div id="panelRegistroJM">
        <div class="registro-panel-card card">

            <div class="registro-panel-header">
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <span style="font-weight:800;font-size:16px;">📋 Registro JM</span>
                    <div class="periodo-tabs">
                        <button class="periodo-tab active" onclick="cargarPeriodo('dia',this)">📅 Día</button>
                        <button class="periodo-tab"        onclick="cargarPeriodo('semana',this)">📆 Semana</button>
                        <button class="periodo-tab"        onclick="cargarPeriodo('mes',this)">🗓️ Mes</button>
                    </div>
                </div>
                <div class="export-btns">
                    <button class="btn-exp btn-exp-pdf"  onclick="exportar('pdf')">📄 PDF</button>
                    <button class="btn-exp btn-exp-word" onclick="exportar('word')">📝 Word</button>
                </div>
            </div>

            <div class="registro-resumen">
                <div class="resumen-item">
                    <span class="resumen-label">Período</span>
                    <span class="resumen-valor" id="resumenPeriodo">—</span>
                </div>
                <div class="resumen-item ms-4">
                    <span class="resumen-label">Total Servicios</span>
                    <span class="resumen-valor" id="resumenTotal">0</span>
                </div>
                <div class="resumen-item ms-4">
                    <span class="resumen-label">Total Recaudado</span>
                    <span class="resumen-valor verde" id="resumenMonto">Bs. 0.00</span>
                </div>
            </div>

            <div id="registroContenido">
                <div class="jm-loading">
                    <div class="jm-spinner"></div>
                    <p>Cargando registros...</p>
                </div>
            </div>

        </div>
    </div>

    {{-- TABLA TRABAJADORES --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header text-white" style="background:linear-gradient(135deg,#0b2f5b,#114c8d);">
            <h5 class="mb-0">👷 Listado de Trabajadores</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Trabajador</th>
                            <th>Servicios Hoy</th>
                            <th>Ganancia Hoy</th>
                            <th>Ganancia Sistema JM</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trabajadores as $t)
                        <tr style="cursor:pointer"
                            onclick="window.location='{{ route('reportes.trabajador', $t->id) }}'">
                            <td class="fw-semibold">
                                <i class="bi bi-person-circle me-1"></i>{{ $t->nombre }}
                            </td>
                            <td>
                                <span class="badge bg-primary rounded-pill px-3 py-2">{{ $t->total_hoy }}</span>
                            </td>
                            <td>
                                <span class="badge bg-success rounded-pill px-3 py-2">Bs. {{ number_format($t->ganancia_hoy, 2) }}</span>
                            </td>
                            <td>
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2">Bs. {{ number_format($t->ganancia_sistema_hoy ?? 0, 2) }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-muted py-5">
                                <i class="bi bi-inbox fs-1"></i>
                                <p class="mt-2 mb-0">No hay registros hoy</p>
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
let periodoActual = 'dia';
let panelAbierto  = false;

function toggleRegistroJM() {
    const panel = document.getElementById('panelRegistroJM');
    const btn   = document.getElementById('btnRegistroJM');
    panelAbierto = !panelAbierto;
    if (panelAbierto) {
        panel.classList.add('show');
        btn.classList.add('activo');
        btn.textContent = '✖ Cerrar Registro';
        cargarPeriodo('dia', document.querySelector('.periodo-tab'));
    } else {
        panel.classList.remove('show');
        btn.classList.remove('activo');
        btn.innerHTML = '📋 Registro JM';
    }
}

function cargarPeriodo(periodo, tabEl) {
    periodoActual = periodo;
    document.querySelectorAll('.periodo-tab').forEach(t => t.classList.remove('active'));
    if (tabEl) tabEl.classList.add('active');

    document.getElementById('registroContenido').innerHTML = `
        <div class="jm-loading">
            <div class="jm-spinner"></div>
            <p>Cargando registros...</p>
        </div>`;

    const endpoints = {
        dia:    '{{ route("reportes.registros.dia") }}',
        semana: '{{ route("reportes.registros.semana") }}',
        mes:    '{{ route("reportes.registros.mes") }}',
    };

    fetch(endpoints[periodo], {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        document.getElementById('resumenPeriodo').textContent = data.periodo;
        document.getElementById('resumenTotal').textContent   = data.totalOrdenes;
        document.getElementById('resumenMonto').textContent   = 'Bs. ' + data.total;

        if (!data.ordenes || data.ordenes.length === 0) {
            document.getElementById('registroContenido').innerHTML = `
                <div class="sin-datos">
                    <i class="bi bi-inbox" style="font-size:2.5rem;"></i>
                    <p class="mt-2 mb-0">No hay registros para este período</p>
                </div>`;
            return;
        }

        const filas = data.ordenes.map(o => `
            <tr>
                <td class="fw-semibold">#${o.id_orden}</td>
                <td>${o.fecha}</td>
                <td>${o.cliente}</td>
                <td>${o.moto}<br><small class="text-muted">${o.placa}</small></td>
                <td>${o.servicio}</td>
                <td>${o.trabajador}</td>
                <td><span class="badge bg-success rounded-pill px-3">Bs. ${o.precio}</span></td>
                <td><span class="badge-pill-sm ${badgeMetodo(o.metodo_pago)}">${o.metodo_pago}</span></td>
                <td><span class="badge-pill-sm ${badgeEstado(o.estado_pago)}">${o.estado_pago}</span></td>
            </tr>`).join('');

        document.getElementById('registroContenido').innerHTML = `
            <div class="table-responsive">
                <table class="tabla-registros">
                    <thead>
                        <tr>
                            <th>#</th><th>Fecha</th><th>Cliente</th><th>Moto / Placa</th>
                            <th>Servicio</th><th>Trabajador</th><th>Precio</th>
                            <th>Método Pago</th><th>Estado Pago</th>
                        </tr>
                    </thead>
                    <tbody>${filas}</tbody>
                </table>
            </div>`;
    })
    .catch(err => {
        document.getElementById('registroContenido').innerHTML = `
            <div class="sin-datos text-danger">
                <i class="bi bi-exclamation-circle" style="font-size:2rem;"></i>
                <p class="mt-2">Error al cargar los datos.</p>
            </div>`;
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
    if (e.includes('parcial'))   return 'bg-info text-dark';
    return 'bg-secondary text-white';
}

function exportar(tipo) {
    const urls = {
        pdf:  '{{ url("/reportes/export/pdf") }}?periodo=' + periodoActual,
        word: '{{ url("/reportes/export/word") }}?periodo=' + periodoActual,
    };
    window.location.href = urls[tipo];
}
</script>

@endsection