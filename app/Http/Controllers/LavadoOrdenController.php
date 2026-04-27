<?php

namespace App\Http\Controllers;

use App\Models\LavadoOrden;
use App\Models\Cliente;
use App\Models\Moto;
use App\Models\Servicio;
use App\Models\Trabajador;
use Illuminate\Http\Request;

class LavadoOrdenController extends Controller
{
    public function index()
    {
        $lavados = LavadoOrden::with([
            'cliente',
            'moto'
        ])->get();

        return view(
            'lavados.index',
            compact('lavados')
        );
    }


    public function create()
    {
        $clientes = Cliente::all();

        $motos = Moto::all();

        $servicios = Servicio::where(
            'estado',
            1
        )->get();

        $trabajadores = Trabajador::all();

        return view(
            'lavados.create',
            compact(
                'clientes',
                'motos',
                'servicios',
                'trabajadores'
            )
        );
    }



    public function store(Request $request)
    {
        $request->validate([
            'cliente_id'    => 'required',
            'moto_id'       => 'required',
            'servicio_id'   => 'required',
            'trabajador_id' => 'required',
        ]);


        $servicio = Servicio::findOrFail(
            $request->servicio_id
        );


        LavadoOrden::create([

            'fecha' => now(),

            'estado' => 'Pendiente',

            'cliente_id' => $request->cliente_id,

            'moto_id' => $request->moto_id,

            'servicio_id' => $request->servicio_id,

            'trabajador_id' => $request->trabajador_id,

            'precio_total' => $servicio->precio

        ]);


        return redirect()
            ->route('lavados.index')
            ->with(
                'success',
                'Lavado registrado correctamente'
            );
    }



    public function show(
        LavadoOrden $lavadoOrden
    ){
        return view(
            'lavados.show',
            compact('lavadoOrden')
        );
    }



    public function edit(
        LavadoOrden $lavadoOrden
    ){
        //
    }



    public function update(
        Request $request,
        LavadoOrden $lavadoOrden
    ){
        //
    }



    public function destroy(
        LavadoOrden $lavadoOrden
    ){
        $lavadoOrden->delete();

        return redirect()
            ->route('lavados.index')
            ->with(
                'success',
                'Orden eliminada'
            );
    }
}