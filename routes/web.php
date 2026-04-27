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

/*
|--------------------------------------------------------------------------
| RUTA PRINCIPAL
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------
    | PERFIL
    |--------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------
    | CRUD PRINCIPAL
    |--------------------------------
    */
    Route::resource('clientes', ClienteController::class);
    Route::resource('motos', MotoController::class);
    Route::resource('servicios', ServicioController::class);
    Route::resource('trabajadores', TrabajadorController::class);
    Route::resource('lavados', LavadoOrdenController::class);

    /*
    |--------------------------------
    | 📊 REPORTES
    |--------------------------------
    */
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');

    Route::get('/reportes/dia', [ReporteController::class, 'dia'])->name('reportes.dia');
    Route::get('/reportes/semana', [ReporteController::class, 'semana'])->name('reportes.semana');
    Route::get('/reportes/mes', [ReporteController::class, 'mes'])->name('reportes.mes');

    Route::get('/reportes/fecha', [ReporteController::class, 'porFecha'])->name('reportes.fecha');
    Route::post('/reportes/fecha', [ReporteController::class, 'buscarFecha'])->name('reportes.fecha.buscar');

    // 👷 REPORTE GANANCIAS TRABAJADORES
    Route::get('/reportes/trabajadores', [ReporteController::class, 'trabajadores'])->name('reportes.trabajadores');

});

require __DIR__.'/auth.php';