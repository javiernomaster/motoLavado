<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LavadoOrden;
use App\Models\Trabajador;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function index()
    {
        return view('reportes.index');
    }

    public function dia()
    {
        $hoy = Carbon::today();

        $total = LavadoOrden::whereDate('created_at', $hoy)->sum('precio_total');
        $servicios = LavadoOrden::whereDate('created_at', $hoy)->get();

        return view('reportes.dia', compact('total', 'servicios'));
    }

    public function semana()
    {
        $inicio = Carbon::now()->startOfWeek();
        $fin = Carbon::now()->endOfWeek();

        $total = LavadoOrden::whereBetween('created_at', [$inicio, $fin])->sum('precio_total');
        $servicios = LavadoOrden::whereBetween('created_at', [$inicio, $fin])->get();

        return view('reportes.semana', compact('total', 'servicios'));
    }

    public function mes()
    {
        $inicio = Carbon::now()->startOfMonth();
        $fin = Carbon::now()->endOfMonth();

        $total = LavadoOrden::whereBetween('created_at', [$inicio, $fin])->sum('precio_total');
        $servicios = LavadoOrden::whereBetween('created_at', [$inicio, $fin])->get();

        return view('reportes.mes', compact('total', 'servicios'));
    }

    public function porFecha()
    {
        return view('reportes.fecha');
    }

    public function buscarFecha(Request $request)
    {
        $fecha = $request->fecha;

        $total = LavadoOrden::whereDate('created_at', $fecha)->sum('precio_total');
        $servicios = LavadoOrden::whereDate('created_at', $fecha)->get();

        return view('reportes.fecha', compact('fecha', 'total', 'servicios'));
    }

    /*
    |--------------------------------------------------
    | REPORTE DE GANANCIAS POR TRABAJADOR
    |--------------------------------------------------
    */
    public function trabajadores()
    {
        $trabajadores = Trabajador::with('lavados')->get()->map(function ($t) {

            $totalServicios = $t->lavados->count();

            $totalGenerado  = $t->lavados->sum('precio_total');

            $ganancia       = $totalGenerado * ($t->porcentaje_comision / 100);

            return [
                'nombre'             => $t->nombre,
                'porcentaje'         => $t->porcentaje_comision,
                'total_servicios'    => $totalServicios,
                'total_generado'     => $totalGenerado,
                'ganancia'           => $ganancia,
            ];
        });

        return view('reportes.trabajadores', compact('trabajadores'));
    }
}