@extends('layouts.app')

@section('content')

<h3 class="mb-4">Dashboard</h3>

<div class="row g-4">

    <div class="col-md-3">
        <div class="card card-box p-3 position-relative">
            <div class="card-icon bg-blue">
                <i class="bi bi-person-badge"></i>
            </div>
            <small>TRABAJADORES</small>
            <h2>5</h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-box p-3 position-relative">
            <div class="card-icon bg-green">
                <i class="bi bi-people"></i>
            </div>
            <small>CLIENTES</small>
            <h2>12</h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-box p-3 position-relative">
            <div class="card-icon bg-orange">
                <i class="bi bi-gear"></i>
            </div>
            <small>SERVICIOS HOY</small>
            <h2>3</h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-box p-3 position-relative">
            <div class="card-icon bg-cyan">
                <i class="bi bi-currency-dollar"></i>
            </div>
            <small>INGRESOS HOY</small>
            <h2>Bs. 85</h2>
        </div>
    </div>

</div>

@endsection