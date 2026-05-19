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
use App\Models\DetalleVentaDecant;
use Illuminate\Http\Request;

class InventarioDecantController extends Controller
{
    public function index(Request $request)
    {

        $query = InventarioDecants::with(['decant', 'marca', 'inventario', 'perfume', 'precios_decants']);
        
        if($request->search){
            $query->whereHas('decant.perfume', function($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->search . '%');
            });
        }

        if($request->marca){
            $query->whereHas('decant.perfume.marca', function($q) use ($request) {
                $q->where('id', $request->marca);
            });
        }

        if($request->genero){
            $query->whereHas('decant.perfume', function($q) use ($request) {
                $q->where('genero', $request->genero);
            });
        }

        if($request->tipo){
            $query->whereHas('decant.perfume', function($q) use ($request) {
                $q->where('tipo', $request->tipo);
            });
        }

        if($request->concentracion){
            $query->whereHas('decant.perfume', function($q) use ($request) {
                $q->where('concentracion', $request->concentracion);
            });
        }

        if($request->categoria){
            $query->whereHas('decant.perfume', function($q) use ($request) {
                $q->where('categoria', $request->categoria);
            });
        }


        $decants = Decant::with(['perfume', 'inventario'])->get();

        $marcas = Marca::orderBy('nombre','asc')->get();

        $perfumes = Perfume::with('marca')->orderBy('nombre')->get();
        
        $inventario_decants = $query->paginate(10)->withQueryString();
        
        return view('principal.inventario_decants', compact('inventario_decants', 'perfumes', 'marcas', 'decants')   );
    }


    public function destroy($id){
        $inventarioDecant = InventarioDecants::findOrFail($id);

        // Evitar eliminación si hay detalles de venta que referencien este inventario_decant_id
        if($inventarioDecant->detalleVentaDecants()->exists() || 
           \App\Models\DetalleVentaDecant::where('inventario_decant_id', $inventarioDecant->id)->exists()){
            return redirect()->back()->with(
                'error',
                'No se puede eliminar el decant del inventario porque tiene ventas asociadas'
            );
        }

        $inventarioDecant->delete();

        return back()->with('success', 'Decant eliminado del inventario correctamente');
    }
}
