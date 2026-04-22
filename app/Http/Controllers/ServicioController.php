<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    // LISTAR SERVICIOS
    public function index()
    {
        $servicios = Servicio::all();
        return view('servicios.index', compact('servicios'));
    }

    // FORMULARIO CREAR
    public function create()
    {
        return view('servicios.create');
    }

    // GUARDAR
    public function store(Request $request)
    {
        Servicio::create($request->all());
        return redirect()->route('servicios.index');
    }

    // MOSTRAR UNO
    public function show(string $id)
    {
        $servicio = Servicio::findOrFail($id);
        return view('servicios.show', compact('servicio'));
    }

    // EDITAR
    public function edit(string $id)
    {
        $servicio = Servicio::findOrFail($id);
        return view('servicios.edit', compact('servicio'));
    }

    // ACTUALIZAR
    public function update(Request $request, string $id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->update($request->all());

        return redirect()->route('servicios.index');
    }

    // ELIMINAR
    public function destroy(string $id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->delete();

        return back();
    }
}