<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Marca;
use App\Models\Perfume;
use App\Models\Inventario;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index(Request $request){

        
        $query = Inventario::with(['marca', 'usuario', 'perfume']);

        if($request->search){
            $query->where('nombre','like','%'.$request->search.'%');
        }

        if($request->genero){
            $query->where('genero',$request->genero);
        } 

        if($request->marca){
            $query->where('marca_id',$request->marca);
        }

        if($request->tipo){
            $query->where('tipo',$request->tipo);
        }

        if($request->concentracion){
            $query->where('concentracion',$request->concentracion);
        }

        if($request->categoria){
            $query->where('categoria',$request->categoria);
        }

        

        $marcas = Marca::orderBy('nombre','asc')->get();

        $perfumes = Perfume::with('marca')->orderBy('nombre')->get();

        $inventarios = $query->paginate(10)->withQueryString();

        return view('principal.inventario', compact('inventarios','perfumes', 'marcas'));
    }

    public function store(Request $request){
        $request->validate([
        'precio_compra'=> 'required|numeric|min:0',
        'precio_venta'=> 'required|numeric|min:0',
        'stock'=> 'required|integer|min:0',
        ]);

        $inventario = new Inventario();

        $inventario->perfume_id  = $request->perfume_id;
        $inventario->precio_compra = $request->precio_compra;
        $inventario->precio_venta = $request->precio_venta;
        $inventario->stock = $request->stock;

        $inventario->user_id = auth()->id();
        $inventario->empresa_id = 1;
        
        $inventario->save();

        return redirect()->back()->with('success', 'Perfume guadado en inventario correctamente');


    }

    public function update(Request $request, $id){
        $inventario = Inventario::find($id);
        
        $inventario->precio_compra = $request->precio_compra;
        $inventario->precio_venta = $request->precio_venta;
        $inventario->stock = $request->stock;
        $inventario->save();

        return redirect()->back()->with('success', 'Perfume actualizado correctamente');
    }

    public function destroy($id){
        $inventario = Inventario::findOrFail($id);

        $inventario->delete();
        return redirect()->back()->with('success', 'Prodcuto eliminada correctamente');
    }

}
