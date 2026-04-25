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
                <h2>0</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-box p-3 position-relative">
                <div class="card-icon bg-green">
                    <i class="bi bi-people"></i>
                </div>
                <small>CLIENTES</small>
                <h2>0</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-box p-3 position-relative">
                <div class="card-icon bg-orange">
                    <i class="bi bi-gear"></i>
                </div>
                <small>SERVICIOS HOY</small>
                <h2>0</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-box p-3 position-relative">
                <div class="card-icon bg-cyan">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <small>INGRESOS HOY</small>
                <h2>Bs.00</h2>
            </div>
        </div>

    </div>

</div>

@endsection