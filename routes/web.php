<?php

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\MarcaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('marca', MarcaController::class);

Route::resource('usuario', UsuarioController::class);
