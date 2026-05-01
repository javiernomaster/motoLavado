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
                $q->whereBetween('fecha', [
                    $hoy->copy()->startOfDay(),
                    $hoy->copy()->endOfDay()
                ]);
            }])
            ->withSum(['lavados as ganancia_hoy' => function ($q) use ($hoy) {
                $q->whereBetween('fecha', [
                    $hoy->copy()->startOfDay(),
                    $hoy->copy()->endOfDay()
                ]);
            }], 'precio_total')
            ->get()
            ->map(function ($t) {
                $totalBruto = $t->ganancia_hoy ?? 0;
                $porcentaje = $t->porcentaje_comision ?? 50;

                $t->ganancia_hoy         = $totalBruto * ($porcentaje / 100);
                $t->ganancia_sistema_hoy = $totalBruto * ((100 - $porcentaje) / 100);

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
        $hoy = Carbon::today();

        $trabajador = Trabajador::findOrFail($id);

        $ordenes = LavadoOrden::where('trabajador_id', $id)
            ->whereBetween('fecha', [
                $hoy->copy()->startOfDay(),
                $hoy->copy()->endOfDay()
            ])
            ->with(['cliente', 'moto', 'servicio'])
            ->get();

        return view('reportes.trabajador', compact('trabajador', 'ordenes'));
    }

    public function serviciosHoy()
    {
        $hoy = Carbon::today();

        $ordenes = LavadoOrden::whereBetween('fecha', [
                $hoy->copy()->startOfDay(),
                $hoy->copy()->endOfDay()
            ])
            ->with(['cliente', 'moto', 'servicio', 'trabajador'])
            ->get();

        return view('reportes.servicios_hoy', compact('ordenes'));
    }

    public function registrosDia(Request $request)
    {
        $fecha = $request->filled('fecha')
            ? Carbon::parse($request->fecha)
            : Carbon::today();

        $ordenes = LavadoOrden::whereBetween('fecha', [
                $fecha->copy()->startOfDay(),
                $fecha->copy()->endOfDay()
            ])
            ->with(['cliente', 'moto', 'servicio', 'trabajador'])
            ->orderBy('fecha', 'desc')
            ->get();

        return response()->json([
            'ordenes'      => $ordenes->map(fn($o) => $this->formatOrden($o)),
            'total'        => number_format($ordenes->sum('precio_total'), 2),
            'totalOrdenes' => $ordenes->count(),
            'periodo'      => $fecha->locale('es')->isoFormat('dddd, D [de] MMMM YYYY'),
        ]);
    }

    public function registrosSemana(Request $request)
    {
        $inicio = Carbon::now()->startOfWeek();
        $fin    = Carbon::now()->endOfWeek();

        $ordenes = LavadoOrden::whereBetween('fecha', [$inicio, $fin])
            ->with(['cliente', 'moto', 'servicio', 'trabajador'])
            ->orderBy('fecha', 'desc')
            ->get();

        return response()->json([
            'ordenes'      => $ordenes->map(fn($o) => $this->formatOrden($o)),
            'total'        => number_format($ordenes->sum('precio_total'), 2),
            'totalOrdenes' => $ordenes->count(),
            'periodo'      => $inicio->locale('es')->isoFormat('D MMM') . ' – ' . $fin->locale('es')->isoFormat('D [de] MMMM YYYY'),
        ]);
    }

    public function registrosMes(Request $request)
    {
        $inicio = Carbon::now()->startOfMonth();
        $fin    = Carbon::now()->endOfMonth();

        $ordenes = LavadoOrden::whereBetween('fecha', [$inicio, $fin])
            ->with(['cliente', 'moto', 'servicio', 'trabajador'])
            ->orderBy('fecha', 'desc')
            ->get();

        return response()->json([
            'ordenes'      => $ordenes->map(fn($o) => $this->formatOrden($o)),
            'total'        => number_format($ordenes->sum('precio_total'), 2),
            'totalOrdenes' => $ordenes->count(),
            'periodo'      => $inicio->locale('es')->isoFormat('MMMM YYYY'),
        ]);
    }

    private function formatOrden(LavadoOrden $o): array
    {
        return [
            'id_orden'    => $o->id_orden,
            'fecha'       => $o->fecha ? $o->fecha->format('d/m/Y') : '—',
            'cliente'     => $o->cliente?->nombre ?? '—',
            'moto'        => $o->moto ? ($o->moto->marca . ' ' . $o->moto->modelo) : '—',
            'placa'       => $o->moto?->placa ?? '—',
            'servicio'    => $o->servicio?->nombre ?? '—',
            'trabajador'  => $o->trabajador?->nombre ?? '—',
            'precio'      => number_format($o->precio_total, 2),
            'metodo_pago' => $o->metodo_pago ?? '—',
            'estado_pago' => $o->estado_pago ?? '—',
        ];
    }

    public function buscarLavado(Request $request)
    {
        $q = $request->get('q', '');

        $ordenes = LavadoOrden::with(['cliente', 'moto', 'servicio', 'trabajador'])
            ->whereHas('cliente', fn($query) => $query->where('nombre', 'like', "%$q%"))
            ->orWhereHas('moto', fn($query) => $query->where('placa', 'like', "%$q%")
                ->orWhere('marca', 'like', "%$q%")
                ->orWhere('modelo', 'like', "%$q%"))
            ->orWhereHas('trabajador', fn($query) => $query->where('nombre', 'like', "%$q%"))
            ->orWhereHas('servicio', fn($query) => $query->where('nombre', 'like', "%$q%"))
            ->orderBy('fecha', 'desc')
            ->limit(15)
            ->get()
            ->map(fn($o) => $this->formatOrden($o));

        return response()->json($ordenes);
    }
}