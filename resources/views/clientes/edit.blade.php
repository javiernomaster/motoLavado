@extends('layouts.app')

@section('content')

<style>
/* ── Header ── */
.jm-header {
    background: linear-gradient(135deg, #071a38 0%, #0b2f5b 45%, #114c8d 100%);
    color: #fff;
    padding: 22px 32px;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(7,26,56,.30);
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
}
.jm-header::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(circle at 80% 50%, rgba(47,109,246,.18) 0%, transparent 60%),
        radial-gradient(circle at 10% 80%, rgba(41,197,216,.10) 0%, transparent 50%);
    pointer-events: none;
}
.jm-header-left { display:flex; align-items:center; gap:16px; position:relative; }
.jm-header-title { font-size:20px; font-weight:800; letter-spacing:.6px; }
.jm-header-subtitle { font-size:13px; opacity:.80; margin-top:2px; }
.jm-header-module {
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.25);
    padding: 5px 16px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 600;
    position: relative;
}
.jm-header-right { display:flex; flex-direction:column; align-items:flex-end; gap:6px; position:relative; }
.jm-date { font-size:13px; opacity:.85; font-weight:500; }

/* ── Panel formulario ── */
.jm-form-wrap {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 6px 24px rgba(0,0,0,.09);
    overflow: hidden;
}

.jm-form-header {
    background: linear-gradient(135deg, #071a38, #114c8d);
    padding: 20px 28px;
    display: flex;
    align-items: center;
    gap: 14px;
}

.jm-form-header-avatar {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.25);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    font-weight: 800;
    color: #fff;
    text-transform: uppercase;
    flex-shrink: 0;
}

.jm-form-header-title {
    color: #fff;
    font-size: 17px;
    font-weight: 800;
    letter-spacing: .4px;
}

.jm-form-header-sub {
    color: rgba(255,255,255,.75);
    font-size: 13px;
    margin-top: 2px;
}

.jm-form-body { padding: 30px 28px; }

/* ── Grupos de campo ── */
.jm-field { margin-bottom: 22px; }

.jm-label {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .6px;
    color: #0b2f5b;
    margin-bottom: 8px;
}

.jm-label .req { color: #e74c3c; font-size: 14px; }

.jm-input {
    width: 100%;
    padding: 12px 16px;
    border: 1.5px solid #dde3ef;
    border-radius: 11px;
    font-size: 14px;
    color: #1f2937;
    background: #f8faff;
    transition: border-color .2s, box-shadow .2s, background .2s;
    outline: none;
    font-family: inherit;
}

.jm-input:focus {
    border-color: #114c8d;
    box-shadow: 0 0 0 3px rgba(17,76,141,.12);
    background: #fff;
}

.jm-input.is-invalid {
    border-color: #e74c3c;
    box-shadow: 0 0 0 3px rgba(231,76,60,.10);
}

.jm-invalid-msg {
    color: #e74c3c;
    font-size: 12px;
    font-weight: 600;
    margin-top: 6px;
    display: flex;
    align-items: center;
    gap: 5px;
}

/* ── Input con ícono ── */
.jm-input-wrap { position: relative; }
.jm-input-wrap .jm-input { padding-left: 42px; }
.jm-input-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 15px;
    pointer-events: none;
}

/* ── Colores íconos ── */
.icon-name   { color: #0b2f5b; }
.icon-ci     { color: #7c3aed; }
.icon-phone  { color: #27ae60; }
.icon-loc    { color: #d6a531; }

/* ── Divider ── */
.jm-divider {
    border: none;
    border-top: 1.5px solid #eef1f8;
    margin: 24px 0;
}

/* ── Botón guardar ── */
.jm-btn-save {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #071a38, #114c8d);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 800;
    letter-spacing: .4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 6px 18px rgba(17,76,141,.30);
    transition: box-shadow .2s, transform .15s;
    font-family: inherit;
}
.jm-btn-save:hover {
    box-shadow: 0 8px 24px rgba(17,76,141,.45);
    transform: translateY(-1px);
}
.jm-btn-save:active { transform: translateY(0); }

/* ── Botón volver ── */
.jm-btn-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 9px 18px;
    border-radius: 10px;
    border: 1.5px solid #cbd5e1;
    background: #fff;
    color: #374151;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: border-color .2s, background .2s;
    font-family: inherit;
}
.jm-btn-back:hover {
    border-color: #0b2f5b;
    color: #0b2f5b;
    background: #f0f5ff;
}
</style>

<div class="container mt-4">

    {{-- ══ HEADER ══ --}}
    <div class="jm-header mb-4">
        <div class="jm-header-left">
            <img src="{{ asset('images/logoM.png') }}"
                 style="width:72px;height:72px;object-fit:contain;">
            <div>
                <div class="jm-header-title">SISTEMA JM</div>
                <div class="jm-header-subtitle">Panel de control</div>
            </div>
        </div>
        <div class="jm-header-right">
            <span class="jm-header-module">
                <i class="bi bi-pencil-square me-1"></i> Editar Cliente
            </span>
            <div class="jm-date">
                {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM YYYY') }}
            </div>
        </div>
    </div>

    {{-- ══ BARRA ACCIONES ══ --}}
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('clientes.index') }}" class="jm-btn-back">
            <i class="bi bi-arrow-left-short" style="font-size:18px"></i> Volver
        </a>
        <div>
            <h5 class="mb-0 fw-bold" style="color:#0b2f5b;">
                <i class="bi bi-pencil-fill me-1"></i> Editando cliente
            </h5>
            <small style="color:#6b7280;">Modifica los datos y guarda los cambios</small>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">

            {{-- ══ FORMULARIO ══ --}}
            <div class="jm-form-wrap">

                {{-- Cabecera con avatar e info del cliente --}}
                <div class="jm-form-header">
                    <div class="jm-form-header-avatar">
                        {{ strtoupper(substr($cliente->nombre, 0, 2)) }}
                    </div>
                    <div>
                        <div class="jm-form-header-title">{{ $cliente->nombre }}</div>
                        <div class="jm-form-header-sub">
                            <i class="bi bi-person-vcard me-1"></i> CI: {{ $cliente->ci }}
                            &nbsp;·&nbsp;
                            <i class="bi bi-hash me-1"></i> ID #{{ $cliente->id }}
                        </div>
                    </div>
                </div>

                <div class="jm-form-body">

                    {{-- Errores de validación --}}
                    @if($errors->any())
                        <div style="background:#fef2f2;border-left:4px solid #e74c3c;border-radius:10px;padding:14px 18px;margin-bottom:22px;">
                            <div style="font-weight:800;color:#b91c1c;font-size:13px;margin-bottom:6px;">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                Corrige los siguientes errores:
                            </div>
                            <ul style="margin:0;padding-left:18px;color:#b91c1c;font-size:13px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('clientes.update', $cliente->id) }}">
                        @csrf
                        @method('PUT')

                        {{-- Nombre --}}
                        <div class="jm-field">
                            <label class="jm-label">
                                <i class="bi bi-person-fill icon-name"></i>
                                Nombre completo <span class="req">*</span>
                            </label>
                            <div class="jm-input-wrap">
                                <i class="bi bi-person-fill jm-input-icon icon-name"></i>
                                <input name="nombre"
                                       value="{{ old('nombre', $cliente->nombre) }}"
                                       class="jm-input @error('nombre') is-invalid @enderror"
                                       placeholder="Nombre completo del cliente">
                            </div>
                            @error('nombre')
                                <div class="jm-invalid-msg">
                                    <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- CI --}}
                        <div class="jm-field">
                            <label class="jm-label">
                                <i class="bi bi-person-vcard icon-ci"></i>
                                Cédula de identidad <span class="req">*</span>
                            </label>
                            <div class="jm-input-wrap">
                                <i class="bi bi-person-vcard jm-input-icon icon-ci"></i>
                                <input name="ci"
                                       value="{{ old('ci', $cliente->ci) }}"
                                       class="jm-input @error('ci') is-invalid @enderror"
                                       placeholder="Número de CI">
                            </div>
                            @error('ci')
                                <div class="jm-invalid-msg">
                                    <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Teléfono --}}
                        <div class="jm-field">
                            <label class="jm-label">
                                <i class="bi bi-telephone-fill icon-phone"></i>
                                Teléfono
                            </label>
                            <div class="jm-input-wrap">
                                <i class="bi bi-telephone-fill jm-input-icon icon-phone"></i>
                                <input name="telefono"
                                       value="{{ old('telefono', $cliente->telefono) }}"
                                       class="jm-input"
                                       placeholder="Número de teléfono">
                            </div>
                        </div>

                        {{-- Dirección --}}
                        <div class="jm-field">
                            <label class="jm-label">
                                <i class="bi bi-geo-alt-fill icon-loc"></i>
                                Dirección
                            </label>
                            <div class="jm-input-wrap">
                                <i class="bi bi-geo-alt-fill jm-input-icon icon-loc"></i>
                                <input name="direccion"
                                       value="{{ old('direccion', $cliente->direccion) }}"
                                       class="jm-input"
                                       placeholder="Dirección del cliente">
                            </div>
                        </div>

                        <hr class="jm-divider">

                        <button type="submit" class="jm-btn-save">
                            <i class="bi bi-floppy-fill"></i>
                            Guardar cambios
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

@endsection