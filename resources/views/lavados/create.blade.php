@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-lg border-0 rounded-4">

                <div class="card-header bg-primary text-white text-center rounded-top-4">
                    <h4 class="mb-0">🚿 Nuevo Lavado</h4>
                </div>

                <div class="card-body p-4">

                    <form action="{{ route('lavados.store') }}" method="POST">
                        @csrf

                        {{-- FECHA --}}
                        <div class="mb-3">
                            <label class="form-label">📅 Fecha</label>
                            <input type="date" name="fecha" class="form-control" required>
                        </div>

                        {{-- CLIENTE --}}
                        <div class="mb-3">
                            <label class="form-label">👤 Cliente</label>
                            <select name="id_cliente" class="form-select" required>
                                <option value="">Seleccione cliente</option>
                                @foreach($clientes as $c)
                                    <option value="{{ $c->id_cliente }}">
                                        {{ $c->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- MOTO --}}
                        <div class="mb-3">
                            <label class="form-label">🏍 Moto</label>
                            <select name="placa" class="form-select" required>
                                <option value="">Seleccione moto</option>
                                @foreach($motos as $m)
                                    <option value="{{ $m->placa }}">
                                        {{ $m->placa }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- BOTÓN --}}
                        <button type="submit" class="btn btn-success w-100 py-2 mt-3">
                            ✔ Guardar Lavado
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection