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


Route::get('/', function () {
    return redirect('/login');
});


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {

 
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/clientes/papelera', [ClienteController::class, 'papelera'])->name('clientes.papelera');
    Route::patch('/clientes/{id}/restaurar', [ClienteController::class, 'restaurar'])->name('clientes.restaurar');
    Route::delete('/clientes/{id}/forzar', [ClienteController::class, 'forzarEliminar'])->name('clientes.forzar');
    Route::resource('clientes', ClienteController::class);

    Route::resource('motos', MotoController::class);
    Route::resource('servicios', ServicioController::class);
    Route::resource('trabajadores', TrabajadorController::class);

    // Lavados: rutas personalizadas DEBEN ir ANTES del Route::resource
    Route::get('/lavados/papelera', [LavadoOrdenController::class, 'papelera'])->name('lavados.papelera');
    Route::patch('/lavados/{id}/restaurar', [LavadoOrdenController::class, 'restaurar'])->name('lavados.restaurar');
    Route::delete('/lavados/{id}/forzar', [LavadoOrdenController::class, 'forzarEliminar'])->name('lavados.forzar');
    Route::resource('lavados', LavadoOrdenController::class);
    Route::patch('/lavados/{lavado}/estado', [LavadoOrdenController::class, 'cambiarEstado'])->name('lavados.estado');
    Route::get('/lavados/{lavado}/historial', [LavadoOrdenController::class, 'historial'])->name('lavados.historial');
    Route::get('/lavados/{lavado}/cobrar', [LavadoOrdenController::class, 'formCobrar'])->name('lavados.cobrar.form');
    Route::patch('/lavados/{lavado}/cobrar', [LavadoOrdenController::class, 'cobrar'])->name('lavados.cobrar');

   
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');

    Route::get('/reportes/dia', [ReporteController::class, 'dia'])->name('reportes.dia');
    Route::get('/reportes/semana', [ReporteController::class, 'semana'])->name('reportes.semana');
    Route::get('/reportes/mes', [ReporteController::class, 'mes'])->name('reportes.mes');

    Route::get('/reportes/fecha', [ReporteController::class, 'porFecha'])->name('reportes.fecha');
    Route::post('/reportes/fecha', [ReporteController::class, 'buscarFecha'])->name('reportes.fecha.buscar');

    
    Route::get('/reportes/trabajadores', [ReporteController::class, 'trabajadores'])->name('reportes.trabajadores');

});

require __DIR__.'/auth.php';