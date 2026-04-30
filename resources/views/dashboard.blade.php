@extends('layouts.app')

@section('content')

<style>

body{
background:#eef3f8;
}

/*======================
HEADER DASHBOARD
=======================*/
.dashboard-header{
background:linear-gradient(135deg,#0b2f5b,#114c8d);
color:#fff;
padding:25px 35px;
border-radius:18px;
box-shadow:0 8px 25px rgba(0,0,0,.15);
margin-bottom:35px;
}

.dashboard-title{
font-weight:700;
letter-spacing:.5px;
margin-bottom:0;
}

.dashboard-sub{
opacity:.85;
font-size:15px;
}

/*======================
SECCION
=======================*/
.section-label{
font-size:20px;
font-weight:700;
color:#334155;
margin-bottom:20px;
}

/*======================
GRID TARJETAS
=======================*/
.stats-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
gap:25px;
}

/*======================
CARD
=======================*/
.stat-card{
background:#fff;
border-radius:16px;
padding:25px;
box-shadow:0 5px 18px rgba(0,0,0,.08);
border-top:5px solid transparent;
transition:.3s ease;
}

.stat-card:hover{
transform:translateY(-5px);
box-shadow:0 12px 25px rgba(0,0,0,.12);
}

.border-blue{
border-top-color:#2f6df6;
}

.border-green{
border-top-color:#27ae60;
}

.border-orange{
border-top-color:#d6a531;
}

.border-teal{
border-top-color:#29c5d8;
}

.stat-top{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:25px;
}

.stat-title{
font-weight:800;
font-size:16px;
color:#1f2937;
}

.stat-sub{
font-size:14px;
color:#6b7280;
}

/* iconos */
.stat-icon{
width:58px;
height:58px;
border-radius:16px;
display:flex;
align-items:center;
justify-content:center;
font-size:28px;
}

.bg-soft-blue{
background:#eaf1ff;
color:#2f6df6;
}

.bg-soft-green{
background:#eaf9ef;
color:#27ae60;
}

.bg-soft-orange{
background:#fff5df;
color:#c99716;
}

.bg-soft-teal{
background:#e8fcff;
color:#29c5d8;
}

.stat-number{
font-size:42px;
font-weight:800;
line-height:1;
}

.text-blue{
color:#2f6df6;
}

.text-green{
color:#27ae60;
}

.text-orange{
color:#c99716;
}

.text-teal{
color:#29c5d8;
}

.money{
font-size:36px;
}

/* Responsive */
@media(max-width:768px){
.dashboard-header{
padding:20px;
}

.stat-number{
font-size:34px;
}
}

</style>


{{-- =======================
HEADER
======================= --}}
<div class="dashboard-header d-flex justify-content-between align-items-center">

<div class="d-flex align-items-center">

<img src="{{ asset('images/logoM.png') }}"
style="
width:85px;
height:85px;
object-fit:contain;
">

<div class="ms-3">
<h3 class="dashboard-title">
SISTEMA JM
</h3>

<div class="dashboard-sub">
Panel de control
</div>
</div>

</div>

<div class="fw-semibold">
{{ now()->locale('es')->isoFormat('dddd, D [de] MMMM YYYY') }}
</div>

</div>



<p class="section-label">
Resumen general
</p>



<div class="stats-grid">

<!-- TRABAJADORES -->
<div class="stat-card border-blue">

<div class="stat-top">

<div>
<div class="stat-title">
TRABAJADORES
</div>

<div class="stat-sub">
Personal activo
</div>
</div>

<div class="stat-icon bg-soft-blue">
<i class="bi bi-person-badge-fill"></i>
</div>

</div>

<div class="stat-number text-blue">
{{ $trabajadores }}
</div>

</div>



<!-- CLIENTES -->
<div class="stat-card border-green">

<div class="stat-top">

<div>
<div class="stat-title">
CLIENTES
</div>

<div class="stat-sub">
Total registrados
</div>
</div>

<div class="stat-icon bg-soft-green">
<i class="bi bi-people-fill"></i>
</div>

</div>

<div class="stat-number text-green">
{{ $clientes }}
</div>

</div>



<!-- SERVICIOS -->
<div class="stat-card border-orange">

<div class="stat-top">

<div>
<div class="stat-title">
SERVICIOS HOY
</div>

<div class="stat-sub">
Realizados hoy
</div>
</div>

<div class="stat-icon bg-soft-orange">
<i class="bi bi-gear-fill"></i>
</div>

</div>

<div class="stat-number text-orange">
{{ $serviciosHoy }}
</div>

</div>



<!-- INGRESOS -->
<div class="stat-card border-teal">

<div class="stat-top">

<div>
<div class="stat-title">
INGRESOS HOY
</div>

<div class="stat-sub">
Recaudado hoy
</div>
</div>

<div class="stat-icon bg-soft-teal">
<i class="bi bi-cash-stack"></i>
</div>

</div>

<div class="stat-number text-teal money">
Bs {{ $ingresosHoy }}
</div>

</div>

</div>

@endsection