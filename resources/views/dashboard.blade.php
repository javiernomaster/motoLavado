@extends('layouts.app')

@section('content')

<div class="container mt-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3 class="mb-0">SISTEMA JM</h3>

        {{-- CERRAR SESIÓN --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="btn btn-outline-danger btn-sm">
                🚪 Cerrar sesión
            </button>
        </form>

    </div>

    {{-- CARDS --}}
    <div class="row g-4">

        <div class="col-md-3">
            <div class="card card-box p-3 position-relative">
                <div class="card-icon bg-blue">
                    <i class="bi bi-person-badge"></i>
                </div>
                <small>TRABAJADORES</small>
                <h2>{{ $trabajadores }}</h2>
            </div>

        <div class="col-md-3">
            <div class="card card-box p-3 position-relative">
                <div class="card-icon bg-green">
                    <i class="bi bi-people"></i>
                </div>
                <small>CLIENTES</small>
                <h2>{{ $clientes }}</h2>
            </div>

        <div class="col-md-3">
            <div class="card card-box p-3 position-relative">
                <div class="card-icon bg-orange">
                    <i class="bi bi-gear"></i>
                </div>
                <small>SERVICIOS HOY</small>
                <h2>{{ $serviciosHoy }}</h2>
            </div>

        <div class="col-md-3">
            <div class="card card-box p-3 position-relative">
                <div class="card-icon bg-cyan">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <small>INGRESOS HOY</small>
                <h2>Bs. {{ number_format($ingresosHoy, 2) }}</h2>
            </div>

    </div>

    {{-- NUEVA FILA: Deudas pendientes --}}
    <div class="row g-4 mt-1">

        <div class="col-md-6">
            <div class="card card-box p-3 position-relative border-danger">
                <div class="card-icon bg-danger">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <small>DEUDA TOTAL PENDIENTE</small>
                <h2 class="text-danger">Bs. {{ number_format($deudaTotal, 2) }}</h2>
            </div>

        <div class="col-md-6">
            <div class="card card-box p-3 position-relative border-warning">
                <div class="card-icon bg-warning">
                    <i class="bi bi-clock-history"></i>
                </div>
                <small>LAVADOS SIN PAGAR</small>
                <h2 class="text-warning">{{ $lavadosPendientesPago }}</h2>
            </div>

    </div>

@endsection
