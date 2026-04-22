<?php

namespace App\Http\Controllers;

use App\Models\Moto;
use App\Models\Cliente;
use Illuminate\Http\Request;

class MotoController extends Controller
{
    public function index()
    {
        $motos = Moto::with('cliente')->get();
        return view('motos.index', compact('motos'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        return view('motos.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'placa' => 'required|string|max:10|unique:motos,placa',
            'marca' => 'required|string|max:50',
            'modelo' => 'required|string|max:50',
            'cliente_id' => 'required|exists:clientes,id'
        ]);

        Moto::create([
            'placa' => $request->placa,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'cliente_id' => $request->cliente_id,
        ]);

        return redirect()->route('motos.index');
    }

    public function edit(Moto $moto)
    {
        $clientes = Cliente::all();
        return view('motos.edit', compact('moto', 'clientes'));
    }

    public function update(Request $request, Moto $moto)
    {
        $request->validate([
            'marca' => 'required|string|max:50',
            'modelo' => 'required|string|max:50',
            'cliente_id' => 'required|exists:clientes,id'
        ]);

        $moto->update([
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'cliente_id' => $request->cliente_id,
        ]);

        return redirect()->route('motos.index');
    }

    public function destroy(Moto $moto)
    {
        $moto->delete();
        return redirect()->route('motos.index');
    }
}