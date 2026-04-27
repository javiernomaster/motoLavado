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

        $serviciosHoy = LavadoOrden::whereDate('created_at', $hoy)->count();

        $ingresosHoy = LavadoOrden::whereDate('created_at', $hoy)
            ->sum('precio_total');

        return view('dashboard', compact(
            'trabajadores',
            'clientes',
            'serviciosHoy',
            'ingresosHoy'
        ));
    }
}