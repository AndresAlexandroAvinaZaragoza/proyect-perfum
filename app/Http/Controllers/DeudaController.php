<?php

namespace App\Http\Controllers;

use App\Models\Deuda;
use Illuminate\Http\Request;

class DeudaController extends Controller
{
    public function index()
    {
        $deudas = Deuda::with(['cliente', 'ultimoAbono'])->get();
        return view('principal.deuda', compact('deudas'));
    }





}
