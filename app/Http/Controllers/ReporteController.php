<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LavadoOrden;
use App\Models\Trabajador;
use Carbon\Carbon;

class ReporteController extends Controller
{
  public function index(Request $request)
{
    $query = \App\Models\LavadoOrden::with(['cliente', 'moto', 'servicio', 'trabajador']);

    $query->when($request->cliente, function ($q) use ($request) {
        $q->where('cliente_id', $request->cliente);
    });

    $query->when($request->estado, function ($q) use ($request) {
        $q->where('estado', $request->estado);
    });

    if ($request->filled('desde') && $request->filled('hasta')) {
        $query->whereBetween('fecha', [$request->desde, $request->hasta]);
    }

    $lavados = $query->orderBy('fecha', 'desc')->get();
    $total   = $lavados->sum('precio_total');

    return view('reportes.index', compact('lavados', 'total'));
}
}