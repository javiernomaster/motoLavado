<?php

namespace App\Http\Controllers;

use App\Models\LavadoOrden;
use App\Models\Trabajador;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $hoy = Carbon::today();

        $trabajadores = Trabajador::where('estado', 1)
            ->withCount(['lavados as total_hoy' => function ($q) use ($hoy) {
                $q->whereDate('fecha', $hoy);
            }])
            ->withSum(['lavados as ganancia_hoy' => function ($q) use ($hoy) {
                $q->whereDate('fecha', $hoy);
            }], 'precio_total')
            ->get()
            ->map(function ($t) {
                $t->ganancia_sistema_hoy = ($t->ganancia_hoy ?? 0) * 0.5;
                $t->ganancia_hoy        = ($t->ganancia_hoy ?? 0) * 0.5;
                return $t;
            });

        $totalServicios       = $trabajadores->sum('total_hoy');
        $gananciaTrabajadores = $trabajadores->sum('ganancia_hoy');
        $gananciaSistema      = $trabajadores->sum('ganancia_sistema_hoy');

        return view('reportes.index', compact(
            'trabajadores',
            'totalServicios',
            'gananciaTrabajadores',
            'gananciaSistema'
        ));
    }

    public function show($id)
    {
        $trabajador = Trabajador::findOrFail($id);

        $ordenes = LavadoOrden::where('trabajador_id', $id)
            ->whereDate('fecha', Carbon::today())
            ->with(['cliente', 'moto', 'servicio'])
            ->get();

        return view('reportes.trabajador', compact('trabajador', 'ordenes'));
    }

    public function serviciosHoy()
    {
        $hoy = Carbon::today();

        $ordenes = LavadoOrden::whereDate('fecha', $hoy)
            ->with(['cliente', 'moto', 'servicio', 'trabajador'])
            ->get();

        return view('reportes.servicios_hoy', compact('ordenes'));
    }

    public function dia(Request $request)
    {
        $fecha = $request->filled('fecha') ? Carbon::parse($request->fecha) : Carbon::today();

        $trabajadores = Trabajador::where('estado', 1)
            ->withCount(['lavados as total_dia' => function ($q) use ($fecha) {
                $q->whereDate('fecha', $fecha);
            }])
            ->withSum(['lavados as ganancia_dia' => function ($q) use ($fecha) {
                $q->whereDate('fecha', $fecha);
            }], 'precio_total')
            ->get();

        return view('reportes.dia', compact('trabajadores', 'fecha'));
    }

    public function semana()
    {
        $inicio = Carbon::now()->startOfWeek();
        $fin    = Carbon::now()->endOfWeek();

        $trabajadores = Trabajador::where('estado', 1)
            ->withCount(['lavados as total_semana' => function ($q) use ($inicio, $fin) {
                $q->whereBetween('fecha', [$inicio, $fin]);
            }])
            ->withSum(['lavados as ganancia_semana' => function ($q) use ($inicio, $fin) {
                $q->whereBetween('fecha', [$inicio, $fin]);
            }], 'precio_total')
            ->get();

        return view('reportes.semana', compact('trabajadores', 'inicio', 'fin'));
    }

    public function mes()
    {
        $inicio = Carbon::now()->startOfMonth();
        $fin    = Carbon::now()->endOfMonth();

        $trabajadores = Trabajador::where('estado', 1)
            ->withCount(['lavados as total_mes' => function ($q) use ($inicio, $fin) {
                $q->whereBetween('fecha', [$inicio, $fin]);
            }])
            ->withSum(['lavados as ganancia_mes' => function ($q) use ($inicio, $fin) {
                $q->whereBetween('fecha', [$inicio, $fin]);
            }], 'precio_total')
            ->get();

        return view('reportes.mes', compact('trabajadores', 'inicio', 'fin'));
    }

    public function porFecha()
    {
        return view('reportes.fecha');
    }

    public function buscarFecha(Request $request)
    {
        $request->validate(['fecha' => 'required|date']);
        $fecha = Carbon::parse($request->fecha);

        $trabajadores = Trabajador::where('estado', 1)
            ->withCount(['lavados as total_fecha' => function ($q) use ($fecha) {
                $q->whereDate('fecha', $fecha);
            }])
            ->withSum(['lavados as ganancia_fecha' => function ($q) use ($fecha) {
                $q->whereDate('fecha', $fecha);
            }], 'precio_total')
            ->get();

        return view('reportes.fecha', compact('trabajadores', 'fecha'));
    }

    public function exportTrabajadoresExcel()
    {
        // Implementar con Laravel Excel si lo tienes instalado
        return back()->with('info', 'Exportación Excel próximamente.');
    }

    public function exportTrabajadoresPdf()
    {
        // Implementar con DomPDF o similar
        return back()->with('info', 'Exportación PDF próximamente.');
    }
}