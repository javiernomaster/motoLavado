<?php

namespace App\Http\Controllers;

use App\Models\LavadoOrden;
use Illuminate\Http\Request;

class LavadoOrdenController extends Controller
{
    public function index()
    {
        $lavados = LavadoOrden::all();
        return view('lavados.index', compact('lavados'));
    }

    public function create()
    {
        return view('lavados.create');
    }

    // 🔥 GUARDAR (CORREGIDO)
    public function store(Request $request)
    {
        LavadoOrden::create([
            'fecha' => $request->fecha,
            'estado' => $request->estado ?? 'Pendiente',
            'cliente_id' => $request->cliente_id,
            'moto_id' => $request->moto_id,
            'servicio_id' => $request->servicio_id,
            'trabajador_id' => $request->trabajador_id,
            'precio_total' => $request->precio_total,
        ]);

        return redirect()->route('lavados.index')
            ->with('success', 'Lavado registrado correctamente');
    }

    public function show(LavadoOrden $lavadoOrden)
    {
        return view('lavados.show', compact('lavadoOrden'));
    }

    public function edit(LavadoOrden $lavadoOrden)
    {
        return view('lavados.edit', compact('lavadoOrden'));
    }

    public function update(Request $request, LavadoOrden $lavadoOrden)
    {
        $lavadoOrden->update([
            'fecha' => $request->fecha,
            'estado' => $request->estado,
            'cliente_id' => $request->cliente_id,
            'moto_id' => $request->moto_id,
            'servicio_id' => $request->servicio_id,
            'trabajador_id' => $request->trabajador_id,
            'precio_total' => $request->precio_total,
        ]);

        return redirect()->route('lavados.index')
            ->with('success', 'Lavado actualizado correctamente');
    }

    public function destroy(LavadoOrden $lavadoOrden)
    {
        $lavadoOrden->delete();

        return redirect()->route('lavados.index')
            ->with('success', 'Lavado eliminado correctamente');
    }
}