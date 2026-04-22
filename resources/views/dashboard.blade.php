@extends('layouts.app')

@section('content')

<h3 class="mb-4">Dashboard</h3>

<div class="row g-4">

    <!-- Usuarios -->
    <div class="col-md-3">
        <div class="card card-box p-3">
            <div class="card-icon bg-blue">
                <i class="bi bi-people"></i>
            </div>
            <small>USUARIOS</small>
            <h2>3</h2>
            <span class="text-muted">Total</span>
        </div>
    </div>

    <!-- Empleados -->
    <div class="col-md-3">
        <div class="card card-box p-3">
            <div class="card-icon bg-green">
                <i class="bi bi-person"></i>
            </div>
            <small>EMPLEADOS</small>
            <h2>2</h2>
            <span class="text-muted">Total</span>
        </div>
    </div>

    <!-- Clientes -->
    <div class="col-md-3">
        <div class="card card-box p-3">
            <div class="card-icon bg-orange">
                <i class="bi bi-people-fill"></i>
            </div>
            <small>CLIENTES</small>
            <h2>4</h2>
            <span class="text-muted">Total</span>
        </div>
    </div>

    <!-- Vehículos -->
    <div class="col-md-3">
        <div class="card card-box p-3">
            <div class="card-icon bg-cyan">
                <i class="bi bi-car-front-fill"></i>
            </div>
            <small>VEHÍCULOS</small>
            <h2>2</h2>
            <span class="text-muted">Total</span>
        </div>
    </div>

    <!-- Servicios -->
    <div class="col-md-3">
        <div class="card card-box p-3">
            <div class="card-icon bg-green">
                <i class="bi bi-gear"></i>
            </div>
            <small>SERVICIOS</small>
            <h2>7</h2>
            <span class="text-muted">Total</span>
        </div>
    </div>

    <!-- Lavados Hoy -->
    <div class="col-md-3">
        <div class="card card-box p-3">
            <div class="card-icon bg-blue">
                <i class="bi bi-car-front"></i>
            </div>
            <small>LAVADOS HOY</small>
            <h2>3</h2>
            <span class="text-muted">Hoy</span>
        </div>
    </div>

    <!-- Lavados Mes -->
    <div class="col-md-3">
        <div class="card card-box p-3">
            <div class="card-icon bg-orange">
                <i class="bi bi-calendar"></i>
            </div>
            <small>LAVADOS MES</small>
            <h2>3</h2>
            <span class="text-muted">Este mes</span>
        </div>
    </div>

    <!-- Ingresos Hoy -->
    <div class="col-md-3">
        <div class="card card-box p-3">
            <div class="card-icon bg-green">
                <i class="bi bi-currency-dollar"></i>
            </div>
            <small>INGRESOS HOY</small>
            <h2>Bs. 85.00</h2>
            <span class="text-muted">Hoy</span>
        </div>
    </div>

</div>

 <div class="col-md-3">
        <div class="card card-box p-3">
            <div class="card-icon bg-green">
                <i class="bi bi-currency-dollar"></i>
            </div>
            <small>INGRESOS HOY</small>
            <h2>Bs. 00.00</h2>
            <span class="text-muted">Hoy</span>
        </div>
    </div>

@endsection

