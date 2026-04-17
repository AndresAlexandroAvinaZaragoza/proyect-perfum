<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\PrecioDecant;
use App\Models\Empresa;
use App\Models\User;
use App\Models\Perfume;
use App\Models\Inventario;
use App\Models\Decant;
use App\Models\InventarioDecants;
use Illuminate\Http\Request;

class InventarioDecantController extends Controller
{
    public function index()
    {

        $query = InventarioDecants::with(['decant', 'marca', 'inventario', 'perfume', 'precios_decants']);
        
        $decants = Decant::with(['perfume', 'inventario'])->get();

        $marcas = Marca::orderBy('nombre','asc')->get();

        $perfumes = Perfume::with('marca')->orderBy('nombre')->get();
        
        $inventario_decants = $query->paginate(10);
        
        return view('principal.inventario_decants', compact('inventario_decants', 'perfumes', 'marcas', 'decants')   );
    }


    public function destroy($id){
        $inventarioDecant = InventarioDecants::findOrFail($id);
        $inventarioDecant->delete();

        return back()->with('success', 'Decant eliminado del inventario correctamente');
    }
}
