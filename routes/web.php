<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MotoController;
use App\Http\Controllers\LavadoOrdenController;
use App\Http\Controllers\ServicioController;      
use App\Http\Controllers\TrabajadorController;    
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('/login');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    
    Route::resource('clientes', ClienteController::class);
    Route::resource('motos', MotoController::class);
    Route::resource('servicios', ServicioController::class);     
    Route::resource('trabajadores', TrabajadorController::class);
    Route::resource('lavados', LavadoOrdenController::class);
});


require __DIR__.'/auth.php';