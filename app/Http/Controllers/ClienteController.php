<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Cliente::with('motos');

        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                  ->orWhere('ci', 'like', "%{$buscar}%")
                  ->orWhere('telefono', 'like', "%{$buscar}%")
                  ->orWhere('direccion', 'like', "%{$buscar}%");
            });
        }

        // ✅ PRIMERO el total, LUEGO el paginate
        $totalClientes = $query->count();
        $clientes = $query->paginate(15)->withQueryString();

        return view('clientes.index', compact('clientes', 'totalClientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(StoreClienteRequest $request)
    {
        Cliente::create($request->validated());

        return redirect()->route('clientes.index')->with('success', 'Cliente registrado correctamente.');
    }

    public function show(Cliente $cliente)
    {
        $cliente->load(['motos.lavados.servicio', 'motos.lavados.trabajador', 'lavados.moto', 'lavados.servicio', 'lavados.trabajador']);

        $totalLavados   = $cliente->lavados->count();
        $totalGastado   = $cliente->lavados->sum('precio_total');
        $totalPagado    = $cliente->lavados->sum('monto_pagado');
        $saldoPendiente = $cliente->lavados->sum('saldo');
        $ultimaVisita   = $cliente->lavados->sortByDesc('fecha')->first();

        return view('clientes.show', compact('cliente', 'totalLavados', 'totalGastado', 'totalPagado', 'saldoPendiente', 'ultimaVisita'));
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        $cliente->update($request->validated());

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(Cliente $cliente)
    {
        if ($cliente->motos()->count() > 0) {
            return redirect()->route('clientes.index')->with('error', 'No se puede eliminar el cliente porque tiene motos registradas.');
        }

        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente.');
    }

    public function papelera()
    {
        $clientes = Cliente::onlyTrashed()->withCount('motos')->paginate(15);
        return view('clientes.papelera', compact('clientes'));
    }

    public function restaurar($id)
    {
        $cliente = Cliente::onlyTrashed()->findOrFail($id);
        $cliente->restore();

        return redirect()->route('clientes.papelera')->with('success', 'Cliente restaurado correctamente.');
    }

    public function forzarEliminar($id)
    {
        $cliente = Cliente::onlyTrashed()->findOrFail($id);

        if ($cliente->motos()->withTrashed()->count() > 0) {
            return redirect()->route('clientes.papelera')->with('error', 'No se puede eliminar permanentemente porque tiene motos registradas.');
        }

        if ($cliente->lavados()->withTrashed()->count() > 0) {
            return redirect()->route('clientes.papelera')->with('error', 'No se puede eliminar permanentemente porque tiene lavados registrados en el historial.');
        }

        $cliente->forceDelete();

        return redirect()->route('clientes.papelera')->with('success', 'Cliente eliminado permanentemente.');
    }
}