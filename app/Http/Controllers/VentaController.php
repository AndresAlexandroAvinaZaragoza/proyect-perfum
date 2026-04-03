<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Detalle_Venta;
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


    public function store(Request $request){
        DB::beginTransaction();

        try{
            //Crear venta
            $venta = Venta::create([
                'cliente_id' => $request->cliente_id,
                'total' => $request->total,
                'tipo_venta' => $request->metodo_pago,
                'articulos' => $request->articulos,
                'user_id' => auth()->id(),
                'empresa_id' => 1
            ]);

            //Convertir el carrito de JSON a un array
            $carrito = json_decode($request->carrito, true);

            foreach($carrito as $item){

                //guardar detalle en la tabla detalle__venta
                Detalle_Venta::create([
                    'venta_id' => $venta->id,
                    'perfume_id' => $item['id'], //enrealidad es del inventario pero como el perfume es unico por inventario se puede usar el mismo id
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                    'subtotal' => $item['precio'] * $item['cantidad'],
                    'empresa_id' => 1
                ]);

                //Actualizar stock en inventario
                $inventario = Inventario::find($item['id']);
                $inventario->stock -= $item['cantidad'];
                $inventario->save();
            }
            DB::commit();


        }catch(\Exception $e){
            DB::rollback();
            dd($e->getMessage());
        }

        return back()->with('success', 'Venta registrada exitosamente.');
    }
}
