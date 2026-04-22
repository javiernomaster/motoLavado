<?php

namespace App\Http\Controllers;

use App\Models\Trabajador;
use Illuminate\Http\Request;

class TrabajadorController extends Controller
{
    public function index()
    {
        $trabajadores = Trabajador::all();
        return view('trabajadores.index', compact('trabajadores'));
    }

    public function create()
    {
        return view('trabajadores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'ci' => 'required|unique:trabajadores,ci',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
            'porcentaje_comision' => 'required|numeric|min:1|max:100',
            'estado' => 'required|in:activo,inactivo'
        ]);

        Trabajador::create($request->all());

        return redirect()->route('trabajadores.index');
    }

    public function edit(Trabajador $trabajador)
    {
        return view('trabajadores.edit', compact('trabajador'));
    }

    public function update(Request $request, Trabajador $trabajador)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'ci' => 'required|unique:trabajadores,ci,' . $trabajador->id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
            'porcentaje_comision' => 'required|numeric|min:1|max:100',
            'estado' => 'required|in:activo,inactivo'
        ]);

        $trabajador->update($request->all());

        return redirect()->route('trabajadores.index');
    }

    public function destroy(Trabajador $trabajador)
    {
        $trabajador->delete();
        return redirect()->route('trabajadores.index');
    }
}