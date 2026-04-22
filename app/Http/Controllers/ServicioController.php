<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index()
    {
        $servicios = Servicio::all();
        return view('servicios.index', compact('servicios'));
    }

    public function create()
    {
        return view('servicios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'tiempo_estimado' => 'nullable|integer|min:1',
            'estado' => 'required|in:activo,inactivo'
        ]);

        Servicio::create($request->all());

        return redirect()->route('servicios.index');
    }

    public function edit(Servicio $servicio)
    {
        return view('servicios.edit', compact('servicio'));
    }

    public function update(Request $request, Servicio $servicio)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'tiempo_estimado' => 'nullable|integer|min:1',
            'estado' => 'required|in:activo,inactivo'
        ]);

        $servicio->update($request->all());

        return redirect()->route('servicios.index');
    }

    public function destroy(Servicio $servicio)
    {
        $servicio->delete();

        return redirect()->route('servicios.index');
    }
}