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
            'trabajadores', 'totalServicios', 'gananciaTrabajadores', 'gananciaSistema'
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

    public function registrosDia(Request $request)
    {
        $fecha   = $request->filled('fecha') ? Carbon::parse($request->fecha) : Carbon::today();
        $ordenes = LavadoOrden::whereDate('fecha', $fecha)
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
        $inicio  = Carbon::now()->startOfWeek();
        $fin     = Carbon::now()->endOfWeek();
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
        $inicio  = Carbon::now()->startOfMonth();
        $fin     = Carbon::now()->endOfMonth();
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

    private function getOrdenesPorPeriodo(string $periodo)
    {
        return match ($periodo) {
            'semana' => LavadoOrden::whereBetween('fecha', [
                Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek(),
            ])->with(['cliente', 'moto', 'servicio', 'trabajador'])->get(),
            'mes' => LavadoOrden::whereBetween('fecha', [
                Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth(),
            ])->with(['cliente', 'moto', 'servicio', 'trabajador'])->get(),
            default => LavadoOrden::whereDate('fecha', Carbon::today())
                ->with(['cliente', 'moto', 'servicio', 'trabajador'])->get(),
        };
    }

    public function buscarLavado(Request $request)
{
    $q = $request->get('q', '');

    $ordenes = LavadoOrden::with(['cliente', 'moto', 'servicio', 'trabajador'])
        ->whereHas('cliente',   fn($query) => $query->where('nombre', 'like', "%$q%"))
        ->orWhereHas('moto',    fn($query) => $query->where('placa',  'like', "%$q%")
                                                     ->orWhere('marca', 'like', "%$q%")
                                                     ->orWhere('modelo','like', "%$q%"))
        ->orWhereHas('trabajador', fn($query) => $query->where('nombre', 'like', "%$q%"))
        ->orWhereHas('servicio',   fn($query) => $query->where('nombre', 'like', "%$q%"))
        ->orderBy('fecha', 'desc')
        ->limit(15)
        ->get()
        ->map(fn($o) => $this->formatOrden($o));

    return response()->json($ordenes);
}
    public function exportRegistrosPdf(Request $request)
    {
        $periodo = $request->get('periodo', 'dia');
        $ordenes = $this->getOrdenesPorPeriodo($periodo);
        $titulo  = match($periodo) {
            'semana' => 'Registros de la Semana',
            'mes'    => 'Registros del Mes',
            default  => 'Registros del Día',
        };

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reportes.export_pdf', compact('ordenes', 'titulo', 'periodo'));
        return $pdf->download('registro_jm_' . $periodo . '.pdf');
    }

    public function exportRegistrosWord(Request $request)
    {
        $periodo = $request->get('periodo', 'dia');
        $ordenes = $this->getOrdenesPorPeriodo($periodo);
        $titulo  = match($periodo) {
            'semana' => 'Registros de la Semana',
            'mes'    => 'Registros del Mes',
            default  => 'Registros del Día',
        };

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();

        $section->addText($titulo, ['bold' => true, 'size' => 16]);
        $section->addText('Generado: ' . now()->format('d/m/Y H:i'), ['size' => 10, 'color' => '888888']);
        $section->addTextBreak(1);

        $table = $section->addTable(['borderSize' => 6, 'borderColor' => '999999', 'cellMargin' => 80]);

        $table->addRow();
        foreach (['#', 'Fecha', 'Cliente', 'Moto', 'Placa', 'Servicio', 'Trabajador', 'Precio', 'Método', 'Estado'] as $col) {
            $cell = $table->addCell(1500, ['bgColor' => '0b2f5b']);
            $cell->addText($col, ['bold' => true, 'color' => 'FFFFFF', 'size' => 9]);
        }

        foreach ($ordenes as $o) {
            $table->addRow();
            foreach ([
                $o->id_orden,
                $o->fecha?->format('d/m/Y') ?? '—',
                $o->cliente?->nombre ?? '—',
                $o->moto ? $o->moto->marca . ' ' . $o->moto->modelo : '—',
                $o->moto?->placa ?? '—',
                $o->servicio?->nombre ?? '—',
                $o->trabajador?->nombre ?? '—',
                'Bs. ' . number_format($o->precio_total, 2),
                $o->metodo_pago ?? '—',
                $o->estado_pago ?? '—',
            ] as $val) {
                $table->addCell(1500)->addText((string) $val, ['size' => 8]);
            }
        }

        $filename = 'registro_jm_' . $periodo . '.docx';
        $tmpPath  = storage_path('app/' . $filename);

        $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tmpPath);

        return response()->download($tmpPath, $filename)->deleteFileAfterSend(true);
    }

    public function dia(Request $request)
    {
        $fecha = $request->filled('fecha') ? Carbon::parse($request->fecha) : Carbon::today();
        $trabajadores = Trabajador::where('estado', 1)
            ->withCount(['lavados as total_dia' => fn($q) => $q->whereDate('fecha', $fecha)])
            ->withSum(['lavados as ganancia_dia' => fn($q) => $q->whereDate('fecha', $fecha)], 'precio_total')
            ->get();
        return view('reportes.dia', compact('trabajadores', 'fecha'));
    }

    public function semana()
    {
        $inicio = Carbon::now()->startOfWeek();
        $fin    = Carbon::now()->endOfWeek();
        $trabajadores = Trabajador::where('estado', 1)
            ->withCount(['lavados as total_semana' => fn($q) => $q->whereBetween('fecha', [$inicio, $fin])])
            ->withSum(['lavados as ganancia_semana' => fn($q) => $q->whereBetween('fecha', [$inicio, $fin])], 'precio_total')
            ->get();
        return view('reportes.semana', compact('trabajadores', 'inicio', 'fin'));
    }

    public function mes()
    {
        $inicio = Carbon::now()->startOfMonth();
        $fin    = Carbon::now()->endOfMonth();
        $trabajadores = Trabajador::where('estado', 1)
            ->withCount(['lavados as total_mes' => fn($q) => $q->whereBetween('fecha', [$inicio, $fin])])
            ->withSum(['lavados as ganancia_mes' => fn($q) => $q->whereBetween('fecha', [$inicio, $fin])], 'precio_total')
            ->get();
        return view('reportes.mes', compact('trabajadores', 'inicio', 'fin'));
    }

public function porFecha()
    {
        return view('reportes.fecha');
    }

    // Método AJAX para buscar por fecha específica
    public function buscarFechaAjax(Request $request)
    {
        $request->validate(['fecha' => 'required|date']);
        $fecha = Carbon::parse($request->fecha);
        
        $ordenes = LavadoOrden::whereDate('fecha', $fecha)
            ->with(['cliente', 'moto', 'servicio', 'trabajador'])
            ->orderBy('fecha', 'desc')
            ->get();

        $total = $ordenes->sum('precio_total');

        return response()->json([
            'ordenes' => $ordenes->map(fn($o) => [
                'id_orden'    => $o->id_orden,
                'cliente'     => $o->cliente?->nombre ?? '—',
                'moto'        => $o->moto ? ($o->moto->marca . ' ' . $o->moto->modelo) : '—',
                'placa'       => $o->moto?->placa ?? '—',
                'trabajador'  => $o->trabajador?->nombre ?? '—',
                'servicio'    => $o->servicio?->nombre ?? '—',
                'precio'      => number_format($o->precio_total, 2),
                'metodo_pago' => $o->metodo_pago ?? '—',
                'estado_pago'=> $o->estado_pago ?? '—',
                'hora'       => $o->fecha ? $o->fecha->format('H:i') : '—',
            ]),
            'total'   => number_format($total, 2),
            'fecha'   => $fecha->locale('es')->isoFormat('dddd, D [de] MMMM YYYY'),
            'count'   => $ordenes->count(),
        ]);
    }

    public function buscarFecha(Request $request)
    {
        $request->validate(['fecha' => 'required|date']);
        $fecha = Carbon::parse($request->fecha);
        
        $ordenes = LavadoOrden::whereDate('fecha', $fecha)
            ->with(['cliente', 'moto', 'servicio', 'trabajador'])
            ->orderBy('fecha', 'desc')
            ->get();

        $total = $ordenes->sum('precio_total');

        return view('reportes.fecha', compact('ordenes', 'fecha', 'total'));
    }

    public function exportTrabajadoresExcel()
    {
        return back()->with('info', 'Exportación Excel próximamente.');
    }

    public function exportTrabajadoresPdf()
    {
        return back()->with('info', 'Exportación PDF próximamente.');
    }
}