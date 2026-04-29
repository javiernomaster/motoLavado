<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MotoController;
use App\Http\Controllers\LavadoOrdenController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect('/login'));

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    // ================= PERFIL =================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ================= CLIENTES =================
    Route::get('clientes/papelera', [ClienteController::class, 'papelera'])->name('clientes.papelera');
    Route::patch('clientes/{cliente}/restaurar', [ClienteController::class, 'restaurar'])->name('clientes.restaurar');
    Route::delete('clientes/{cliente}/forzar', [ClienteController::class, 'forzarEliminar'])->name('clientes.forzar');
    Route::resource('clientes', ClienteController::class);

    // ================= TRABAJADORES =================
    Route::get('trabajadores/papelera', [TrabajadorController::class, 'papelera'])->name('trabajadores.papelera');
    Route::patch('trabajadores/{trabajador}/restaurar', [TrabajadorController::class, 'restaurar'])->name('trabajadores.restaurar');
    Route::delete('trabajadores/{trabajador}/forzar', [TrabajadorController::class, 'forzarEliminar'])->name('trabajadores.forzar');
    Route::resource('trabajadores', TrabajadorController::class);

    // ================= SERVICIOS =================
    Route::get('servicios/papelera', [ServicioController::class, 'papelera'])->name('servicios.papelera');
    Route::patch('servicios/{servicio}/restaurar', [ServicioController::class, 'restaurar'])->name('servicios.restaurar');
    Route::delete('servicios/{servicio}/forzar', [ServicioController::class, 'forzarEliminar'])->name('servicios.forzar');
    Route::resource('servicios', ServicioController::class);

    // ================= MOTOS =================
    Route::get('motos/papelera', [MotoController::class, 'papelera'])->name('motos.papelera');
    Route::patch('motos/{moto}/restaurar', [MotoController::class, 'restaurar'])->name('motos.restaurar');
    Route::delete('motos/{moto}/forzar', [MotoController::class, 'forzarEliminar'])->name('motos.forzar');
    Route::resource('motos', MotoController::class);

    // ================= LAVADOS =================
    Route::get('lavados/papelera', [LavadoOrdenController::class, 'papelera'])->name('lavados.papelera');
    Route::patch('lavados/{lavado}/restaurar', [LavadoOrdenController::class, 'restaurar'])->name('lavados.restaurar');
    Route::delete('lavados/{lavado}/forzar', [LavadoOrdenController::class, 'forzarEliminar'])->name('lavados.forzar');

    Route::patch('lavados/{lavado}/estado', [LavadoOrdenController::class, 'cambiarEstado'])->name('lavados.estado');
    Route::get('lavados/{lavado}/historial', [LavadoOrdenController::class, 'historial'])->name('lavados.historial');
    Route::get('lavados/{lavado}/cobrar', [LavadoOrdenController::class, 'formCobrar'])->name('lavados.cobrar.form');
    Route::patch('lavados/{lavado}/cobrar', [LavadoOrdenController::class, 'cobrar'])->name('lavados.cobrar');

    Route::resource('lavados', LavadoOrdenController::class);

    // ================= REPORTES =================
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/reportes/dia', [ReporteController::class, 'dia'])->name('reportes.dia');
    Route::get('/reportes/semana', [ReporteController::class, 'semana'])->name('reportes.semana');
    Route::get('/reportes/mes', [ReporteController::class, 'mes'])->name('reportes.mes');
    Route::get('/reportes/fecha', [ReporteController::class, 'porFecha'])->name('reportes.fecha');
    Route::post('/reportes/fecha', [ReporteController::class, 'buscarFecha'])->name('reportes.fecha.buscar');
    Route::get('/reportes/trabajadores', [ReporteController::class, 'trabajadores'])->name('reportes.trabajadores');
    Route::get('/reportes/trabajadores-diario', [ReporteController::class, 'dia'])->name('reportes.trabajadores-diario');
    Route::get('/reportes/trabajadores-semanal', [ReporteController::class, 'semana'])->name('reportes.trabajadores-semanal');
    Route::get('/reportes/trabajadores-mensual', [ReporteController::class, 'mes'])->name('reportes.trabajadores-mensual');
    Route::get('/reportes/trabajadores/excel', [ReporteController::class, 'exportTrabajadoresExcel'])->name('reportes.trabajadores.excel');
    Route::get('/reportes/trabajadores/pdf', [ReporteController::class, 'exportTrabajadoresPdf'])->name('reportes.trabajadores.pdf');
});

require __DIR__.'/auth.php';