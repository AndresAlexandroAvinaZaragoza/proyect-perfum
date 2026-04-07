<?php

namespace App\Http\Controllers;

use App\Models\Deuda;
use App\Models\AbonoRegistro;
use Illuminate\Http\Request;

class DeudaController extends Controller
{
    public function index()
    {
        $deudas = Deuda::with(['cliente', 'ultimoAbono'])->get();
        return view('principal.deuda', compact('deudas'));
    }



    public function ultimoAbono()
    {
        // Cambia 'deuda_id' y 'fecha_abono' por los nombres reales de tus columnas
        return $this->hasOne(AbonoRegistro::class, 'deuda_id')->latestOfMany('fecha_abono');
    }

}
