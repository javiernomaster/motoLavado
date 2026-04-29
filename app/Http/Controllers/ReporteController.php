<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LavadoOrden;
use App\Models\Trabajador;
use App\Models\Cliente;
use App\Models\Moto;
use App\Models\Servicio;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Exports\TrabajadoresExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $query = LavadoOrden::with(['cliente', 'moto', 'servicio', 'trabajador']); // Removido filtros estrictos para mostrar todos

        $query->when($request->cliente, function ($q) use ($request) {
            $q->where('cliente_id', $request->cliente);
        });

        $query->when($request->estado, function ($q) use ($request) {
            $q->where('estado', $request->estado);
        });

        if ($request->filled('desde') && $request->filled('hasta')) {
            $query->whereBetween('fecha', [$request->desde, $request->hasta]);
        }

        $lavados = $query->orderBy('fecha', 'desc')->paginate(20);
        $total = $lavados->sum('precio_total');

        return view('reportes.index', compact('lavados', 'total'));
    }

    public function dia()
    {
        $hoy = Carbon::today();
        $trabajadores = $this->reportesPorPeriodo('dia', $hoy);
        return view('reportes.trabajadores-diario', compact('trabajadores'))->with('periodo', 'Diario');
    }

    public function semana()
    {
        $inicioSemana = Carbon::now()->startOfWeek();
        $trabajadores = $this->reportesPorPeriodo('semana', $inicioSemana);
        return view('reportes.trabajadores-semanal', compact('trabajadores'))->with('periodo', 'Semanal');
    }

    public function mes()
    {
        $inicioMes = Carbon::now()->startOfMonth();
        $trabajadores = $this->reportesPorPeriodo('mes', $inicioMes);
        return view('reportes.trabajadores-mensual', compact('trabajadores'))->with('periodo', 'Mensual');
    }

    public function trabajadores(Request $request)
    {
        $query = LavadoOrden::query()
            ->where('estado', 'completado')
            ->where('estado_pago', 'pagado');

        if ($request->filled('trabajador')) {
            $query->where('trabajador_id', $request->trabajador);
        }

        if ($request->filled('desde') && $request->filled('hasta')) {
            $query->whereBetween('fecha', [$request->desde, $request->hasta]);
        }

        $lavadosPorTrabajador = $query->groupBy('trabajador_id')
            ->selectRaw('trabajador_id, count(*) as total_servicios, sum(precio_total) as total_generado')
            ->get();

$trabajadores_disponibles = Trabajador::select('id', 'nombre', 'apellido')
            ->orderBy('nombre')
            ->pluck('nombre', 'id')
            ->map(function ($nombreCompleto, $id) {
                return [$id => $nombreCompleto];
            });

        $trabajadores = Trabajador::whereIn('id', $lavadosPorTrabajador->pluck('trabajador_id'))
            ->get()
            ->map(function ($trabajador) use ($lavadosPorTrabajador) {
                $lavados = $lavadosPorTrabajador->firstWhere('trabajador_id', $trabajador->id);
                return [
                    'nombre' => $trabajador->nombre . ' ' . $trabajador->apellido,
                    'porcentaje' => $trabajador->comision ?: 0,
                    'total_servicios' => $lavados ? $lavados->total_servicios : 0,
                    'total_generado' => $lavados ? $lavados->total_generado : 0,
                    'ganancia' => $lavados ? ($lavados->total_generado * $trabajador->comision / 100) : 0
                ];
            });

        return view('reportes.trabajadores', compact('trabajadores', 'trabajadores_disponibles'));
    }

    private function reportesPorPeriodo($periodo, $fechaInicio)
    {
        $query = LavadoOrden::query()
            ->where('estado', 'completado')
            ->where('estado_pago', 'pagado');

        if ($periodo == 'dia') {
            $query->whereDate('fecha', $fechaInicio);
        } elseif ($periodo == 'semana') {
            $query->whereBetween('fecha', [$fechaInicio, $fechaInicio->copy()->endOfWeek()]);
        } elseif ($periodo == 'mes') {
            $query->whereMonth('fecha', $fechaInicio->month)
                  ->whereYear('fecha', $fechaInicio->year);
        }

        $lavadosPorTrabajador = $query->groupBy('trabajador_id')
            ->selectRaw('trabajador_id, count(*) as total_servicios, sum(precio_total) as total_generado')
            ->get();

        $trabajadores = Trabajador::whereIn('id', $lavadosPorTrabajador->pluck('trabajador_id'))
            ->get()
            ->map(function ($trabajador) use ($lavadosPorTrabajador) {
                $lavados = $lavadosPorTrabajador->firstWhere('trabajador_id', $trabajador->id);
                return [
                    'nombre' => $trabajador->nombre . ' ' . $trabajador->apellido,
                    'porcentaje' => $trabajador->comision ?: 0,
                    'total_servicios' => $lavados ? $lavados->total_servicios : 0,
                    'total_generado' => $lavados ? $lavados->total_generado : 0,
                    'ganancia' => $lavados ? ($lavados->total_generado * $trabajador->comision / 100) : 0
                ];
            });

        return $trabajadores;
    }

    public function exportTrabajadoresExcel(Request $request)
    {
        $trabajadores = $this->getTrabajadoresFiltrados($request);
        return Excel::download(new TrabajadoresExport($trabajadores), 'reporte_trabajadores_' . now()->format('Y-m-d') . '.xlsx');
    }

    public function exportTrabajadoresPdf(Request $request)
    {
        $trabajadores = $this->getTrabajadoresFiltrados($request);
        $periodo = $request->get('periodo', 'General');
$pdf = PDF::loadView('reportes.trabajadores-pdf', compact('trabajadores', 'periodo'));
        return $pdf->download('reporte_trabajadores_' . now()->format('Y-m-d') . '.pdf');
    }

    private function getTrabajadoresFiltrados(Request $request): Collection
    {
        $query = LavadoOrden::query()
            ->where('estado', 'completado')
            ->where('estado_pago', 'pagado');

        if ($request->filled('trabajador')) {
            $query->where('trabajador_id', $request->trabajador);
        }

        if ($request->filled('desde') && $request->filled('hasta')) {
            $query->whereBetween('fecha', [$request->desde, $request->hasta]);
        }

        $lavadosPorTrabajador = $query->groupBy('trabajador_id')
            ->selectRaw('trabajador_id, count(*) as total_servicios, sum(precio_total) as total_generado')
            ->get();

        return Trabajador::whereIn('id', $lavadosPorTrabajador->pluck('trabajador_id'))
            ->get()
            ->map(function ($trabajador) use ($lavadosPorTrabajador) {
                $lavados = $lavadosPorTrabajador->firstWhere('trabajador_id', $trabajador->id);
                return [
                    'nombre' => $trabajador->nombre . ' ' . $trabajador->apellido,
                    'porcentaje' => $trabajador->comision ?: 0,
                    'total_servicios' => $lavados ? $lavados->total_servicios : 0,
                    'total_generado' => $lavados ? $lavados->total_generado : 0,
                    'ganancia' => $lavados ? ($lavados->total_generado * $trabajador->comision / 100) : 0
                ];
            });
    }
}

