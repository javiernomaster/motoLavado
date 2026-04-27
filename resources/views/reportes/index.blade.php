@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3>📊 Módulo de Reportes</h3>

    <p class="text-muted">Selecciona el tipo de reporte que deseas ver</p>

    <div class="row g-3 mt-3">

        <div class="col-md-3">
            <a href="{{ route('reportes.dia') }}" class="btn btn-success w-100 p-3">
                📅 Reporte Día
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('reportes.semana') }}" class="btn btn-primary w-100 p-3">
                📊 Reporte Semana
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('reportes.mes') }}" class="btn btn-warning w-100 p-3">
                📆 Reporte Mes
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('reportes.fecha') }}" class="btn btn-dark w-100 p-3">
                🔎 Por Fecha
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('reportes.trabajadores') }}" class="btn btn-info w-100 p-3">
                👷 Ganancias Trabajadores
            </a>
        </div>

    </div>

</div>
@endsection