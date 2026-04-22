@extends('layouts.app')

@section('content')
<h3>Detalle Lavado #{{ $lavado->id_orden }}</h3>

<div class="card">
    <div class="card-body">
        <p><strong>Fecha:</strong> {{ $lavado->fecha }}</p>
        <p><strong>Estado:</strong> <span class="badge bg-primary">{{ $lavado->estado }}</span></p>
        <p><strong>Cliente:</strong> {{ $lavado->cliente->nombre ?? 'N/A' }}</p>
        <p><strong>Moto:</strong> {{ $lavado->moto->placa ?? 'N/A' }} - {{ $lavado->moto->modelo ?? '' }}</p>
        <p><strong>Servicio:</strong> {{ $lavado->servicio->nombre ?? 'N/A' }}</p>
        <p><strong>Trabajador:</strong> {{ $lavado->trabajador->nombre ?? 'N/A' }}</p>
        <p><strong>Precio:</strong> ${{ number_format($lavado->precio_total, 2) }}</p>
    </div>
</div>

<a href="{{ route('lavados.index') }}" class="btn btn-secondary mt-3">Volver</a>
@endsection
