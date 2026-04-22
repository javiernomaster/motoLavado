<?php

namespace App\Http\Controllers;

use App\Models\Trabajador;
use Illuminate\Http\Request;

class TrabajadorController extends Controller
{
    // LISTAR TRABAJADORES
    public function index()
    {
        $trabajadors = Trabajador::all();
        return view('trabajadors.index', compact('trabajadors'));
    }

    // FORMULARIO CREAR
    public function create()
    {
        return view('trabajadors.create');
    }

    // GUARDAR
    public function store(Request $request)
    {
        Trabajador::create($request->all());
        return redirect()->route('trabajadors.index');
    }

    // MOSTRAR UNO
    public function show(string $id)
    {
        $trabajador = Trabajador::findOrFail($id);
        return view('trabajadors.show', compact('trabajador'));
    }

    // EDITAR
    public function edit(string $id)
    {
        $trabajador = Trabajador::findOrFail($id);
        return view('trabajadors.edit', compact('trabajador'));
    }

    // ACTUALIZAR
    public function update(Request $request, string $id)
    {
        $trabajador = Trabajador::findOrFail($id);
        $trabajador->update($request->all());

        return redirect()->route('trabajadors.index');
    }

    // ELIMINAR
    public function destroy(string $id)
    {
        $trabajador = Trabajador::findOrFail($id);
        $trabajador->delete();

        return back();
    }
}