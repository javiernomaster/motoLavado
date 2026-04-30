<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Trabajador;

class ReporteController extends Controller
{
    public function index()
    {
        $hoy = Carbon::today();

        $trabajadores = Trabajador::with('lavados')->get();

        $totalServicios = 0;
        $gananciaTrabajadores = 0;
        $gananciaSistema = 0;

        foreach ($trabajadores as $t) {

            // 👉 FILTRAR SOLO HOY
            $lavadosHoy = $t->lavados->where('fecha', '>=', $hoy);

            // ✅ TOTAL SERVICIOS HOY
            $t->total_hoy = $lavadosHoy->count();

            // ✅ GANANCIA HOY
            $gananciaHoy = 0;

            foreach ($lavadosHoy as $lavado) {

                $comision = $t->porcentaje_comision / 100;
                $gananciaTrabajador = $lavado->precio_total * $comision;

                $gananciaHoy += $gananciaTrabajador;

                // sistema
                $gananciaSistema += ($lavado->precio_total - $gananciaTrabajador);
            }

            $t->ganancia_hoy = $gananciaHoy;

            // acumuladores generales
            $totalServicios += $t->total_hoy;
            $gananciaTrabajadores += $gananciaHoy;
        }

        return view('reportes.index', compact(
            'trabajadores',
            'totalServicios',
            'gananciaTrabajadores',
            'gananciaSistema'
        ));
    }

    // 🔍 DETALLE
    public function show($id)
    {
        $trabajador = Trabajador::with('lavados.servicio', 'lavados.cliente', 'lavados.moto')
            ->findOrFail($id);

        $hoy = Carbon::today();
        $inicioSemana = Carbon::now()->startOfWeek();
        $inicioMes = Carbon::now()->startOfMonth();

        $lavadosHoy = $trabajador->lavados->where('fecha', '>=', $hoy);
        $lavadosSemana = $trabajador->lavados->where('fecha', '>=', $inicioSemana);
        $lavadosMes = $trabajador->lavados->where('fecha', '>=', $inicioMes);

        $totalGanado = 0;

        foreach ($trabajador->lavados as $lavado) {
            $comision = $trabajador->porcentaje_comision / 100;
            $totalGanado += $lavado->precio_total * $comision;
        }

        return view('reportes.show', compact(
            'trabajador',
            'lavadosHoy',
            'lavadosSemana',
            'lavadosMes',
            'totalGanado'
        ));
    }
}