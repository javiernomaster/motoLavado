<?php

namespace App\Http\Controllers;

use App\Models\Moto;
use App\Models\Cliente;
use Illuminate\Http\Request;

class MotoController extends Controller
{
    // LISTAR
    public function index()
    {
        $motos = Moto::with('cliente')->get();
        return view('motos.index', compact('motos'));
    }

    // FORMULARIO
    public function create()
    {
        $clientes = Cliente::all();
        return view('motos.create', compact('clientes'));
    }

    // GUARDAR
    public function store(Request $request)
    {
        Moto::create($request->all());
        return redirect()->route('motos.index');
    }

    // EDITAR
    public function edit($placa)
    {
        $moto = Moto::findOrFail($placa);
        $clientes = Cliente::all();
        return view('motos.edit', compact('moto','clientes'));
    }

    // ACTUALIZAR
    public function update(Request $request, $placa)
    {
        $moto = Moto::findOrFail($placa);
        $moto->update($request->all());
        return redirect()->route('motos.index');
    }

    // ELIMINAR
    public function destroy($placa)
    {
        Moto::destroy($placa);
        return back();
    }
}