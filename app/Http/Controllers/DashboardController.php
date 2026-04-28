<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trabajador;
use App\Models\Cliente;
use App\Models\LavadoOrden;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $trabajadores = Trabajador::count();
        $clientes = Cliente::count();

        $hoy = Carbon::today();

        $serviciosHoy = LavadoOrden::whereDate('fecha', $hoy)->count();

        // Fix: ingresos reales = monto pagado, no precio total
        $ingresosHoy = LavadoOrden::whereDate('fecha', $hoy)
            ->where('estado_pago', '!=', 'pendiente')
            ->sum('monto_pagado');

        // Deudas pendientes
        $deudaTotal = LavadoOrden::where('estado_pago', '!=', 'pagado')
            ->sum('saldo');

        $lavadosPendientesPago = LavadoOrden::where('estado_pago', 'pendiente')->count();

        return view('dashboard', compact(
            'trabajadores',
            'clientes',
            'serviciosHoy',
            'ingresosHoy',
            'deudaTotal',
            'lavadosPendientesPago'
        ));
    }
}
