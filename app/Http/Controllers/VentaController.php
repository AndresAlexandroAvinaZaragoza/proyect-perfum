<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Perfume;
use App\Models\Inventario;
use App\Models\Cliente;
use App\Models\Venta;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index(Request $request){

        $query = Venta::with(['cliente', 'usuario', 'perfume', 'inventario']);


        $clientes = Cliente::orderBy('nombre')->get();

        //cargamos la relacion perfume
        $inventarios = Inventario::with('perfume')->get();
        return view('principal.venta', compact('clientes', 'inventarios'));
    }
}
