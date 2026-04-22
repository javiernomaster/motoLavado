<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MotoController;
use App\Http\Controllers\LavadoOrdenController;
use App\Http\Controllers\ServicioController;      // 🔥 AGREGADO
use App\Http\Controllers\TrabajadorController;    // 🔥 AGREGADO
use Illuminate\Support\Facades\Route;

// 🔥 REDIRECCIÓN AL LOGIN
Route::get('/', function () {
    return redirect('/login');
});

// 🔐 DASHBOARD PROTEGIDO
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 🔐 PERFIL USUARIO
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 🚀 MÓDULOS PRINCIPALES
    Route::resource('clientes', ClienteController::class);
    Route::resource('motos', MotoController::class);
    Route::resource('servicios', ServicioController::class);     // 🔥 AGREGADO
    Route::resource('trabajadors', TrabajadorController::class); // 🔥 AGREGADO
    Route::resource('lavados', LavadoOrdenController::class);
});

// 🔑 AUTENTICACIÓN
require __DIR__.'/auth.php';