<?php

namespace App\Http\Controllers;

use App\Models\LavadoOrden;
use App\Models\Cliente;
use App\Models\Moto;
use Illuminate\Http\Request;

class LavadoOrdenController extends Controller
{
    // 🔹 LISTAR LAVADOS
    public function index()
    {
        $lavados = LavadoOrden::with(['cliente','moto'])->get();
        return view('lavados.index', compact('lavados'));
    }

    // 🔹 FORMULARIO CREAR
    public function create()
    {
        $clientes = Cliente::all();
        $motos = Moto::all();

        return view('lavados.create', compact('clientes','motos'));
    }

    // 🔹 GUARDAR
    public function store(Request $request)
    {
        LavadoOrden::create($request->all());

        return redirect()->route('lavados.index')
                         ->with('success', 'Lavado registrado correctamente');
    }

    // 🔹 (luego)
    public function show(LavadoOrden $lavado)
    {
        $clientes = Cliente::all();
        $motos = Moto::all();
        $servicios = Servicio::all();
        $trabajadores = Trabajador::all();
        return view('lavados.show', compact('lavado', 'clientes', 'motos', 'servicios', 'trabajadores'));
    }

    public function edit(LavadoOrden $lavado)
    {
        $clientes = Cliente::all();
        $motos = Moto::all();
        $servicios = Servicio::all();
        $trabajadores = Trabajador::all();
        return view('lavados.edit', compact('lavado', 'clientes', 'motos', 'servicios', 'trabajadores'));
    }

    public function update(Request $request, LavadoOrden $lavado)
    {
        $request->validate([
            'fecha' => 'required|date',
            'estado' => 'required',
            'cliente_id' => 'required|exists:clientes,id_cliente',
            'moto_id' => 'required|exists:motos,id',
            'servicio_id' => 'required|exists:servicios,id',
            'trabajador_id' => 'required|exists:trabajadors,id',
            'precio_total' => 'nullable|numeric'
        ]);

        $lavado->update($request->all());
        return redirect()->route('lavados.index')->with('success', 'Lavado actualizado');
    }

    public function destroy(LavadoOrden $lavado)
    {
        $lavado->delete();
        return redirect()->route('lavados.index')->with('success', 'Lavado eliminado');
    }
}
use App\Models\Servicio;
use App\Models\Trabajador;
