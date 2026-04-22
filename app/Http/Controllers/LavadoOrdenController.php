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
    public function show(LavadoOrden $lavadoOrden)
    {
        //
    }

    public function edit(LavadoOrden $lavadoOrden)
    {
        //
    }

    public function update(Request $request, LavadoOrden $lavadoOrden)
    {
        //
    }

    public function destroy(LavadoOrden $lavadoOrden)
    {
        //
    }
}