<?php

namespace App\Http\Controllers;

use App\Models\Pedidos;
use App\Models\DetalleVentaDecant;
use App\Models\InventarioDecants;
use App\Models\Marca;
use Illuminate\Support\Facades\DB;
use App\Models\Deuda;
use App\Models\Detalle_Venta;
use App\Models\User;
use App\Models\Perfume;
use App\Models\Inventario;
use App\Models\Cliente;
use App\Models\Venta;
use App\Models\Proovedor;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PedidosController extends Controller
{
    public function index()
    {
        $query = Pedidos::with(['detalles.perfume', 'proovedor', 'usuario']);
        
        $proovedores = Proovedor::orderBy('nombre')->get();
        $perfumes = Perfume::orderBy('nombre')->get();

        $pedidos = $query->get();   
        return view('principal.pedidos', compact('pedidos', 'proovedores', 'perfumes'));
    }
}

