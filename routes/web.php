<?php

use App\Http\Controllers\MarcaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PerfumeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('marca.index');
});



Route::resource('marca', MarcaController::class)->middleware(['auth', 'verified']);
Route::resource('usuario', UsuarioController::class)->middleware(['auth', 'verified']);
Route::resource('perfume', PerfumeController::class)->middleware(['auth', 'verified']);



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::post('/usuarios', [UsuarioController::class, 'store'])
    ->middleware(['auth', 'role:admin'])
    ->name('usuarios.store');





require __DIR__.'/auth.php';
