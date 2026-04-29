@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('reportes.trabajadores') }}" class="btn btn-secondary me-2">
                ⬅ Volver Reportes Trabajador
            </a>
            <h3 class="mb-0 d-inline">💰 Ingresos {{ $trabajador_nombre ?? '' }}</h3>
        </div>
    </div>

    {{-- TABS PERÍODO --}}
    <ul class="nav nav-tabs mb-4" id="periodoTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="diario-tab" data-bs-toggle="tab" data-bs-target="#diario" type="button">
                📅 Diario Hoy
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="semanal-tab" data-bs-toggle="tab" data-bs-target="#semanal" type="button">
                📈 Semanal
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="mensual-tab" data-bs-toggle="tab" data-bs-target="#mensual" type="button">
                📊 Mensual
            </button>
        </li>
    </ul>

    <div class="tab-content" id="periodoTabContent">
        {{-- DIARIO --}}
        <div class="tab-pane fade show active" id="diario" role="tabpanel">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <h5>Hoy {{ now()->format('d/m/Y') }}</h5>
                    <h2 class="text-success">Bs. {{ number_format($diario_ganancia, 2) }}</h2>
                    <small>{{ $diario_servicios }} servicios ({{ $diario_total_generado }} generado)</small>
                </div>
            </div>
        </div>

        {{-- SEMANAL --}}
        <div class="tab-pane fade" id="semanal" role="tabpanel">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <h6>Semana</h6>
                            <h4 class="text-info">Bs. {{ number_format($semanal_ganancia, 2) }}</h4>
                            <small>{{ $semanal_servicios }} servicios</small>
                        </div>
                        <div class="col-md-4">
                            <h6>Lun</h6>
                            <h5>Bs. {{ number_format($semanal_dias['lun'], 2) }}</h5>
                        </div>
                        <div class="col-md-4">
                            <h6>Dom</h6>
                            <h5>Bs. {{ number_format($semanal_dias['dom'], 2) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MENSUAL --}}
        <div class="tab-pane fade" id="mensual" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5>Mes {{ now()->translatedFormat('F Y') }}</h5>
                    <h2 class="text-warning">Bs. {{ number_format($mensual_ganancia, 2) }}</h2>
                    <small>{{ $mensual_servicios }} servicios ({{ $mensual_total_generado }} generado)</small>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

