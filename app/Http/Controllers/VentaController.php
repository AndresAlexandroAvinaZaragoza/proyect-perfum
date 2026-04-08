<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Deuda;
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
        
        //cargamos la relacion inventario para mostrar solo los perfumes disponibles
        $inventarios = Inventario::with('perfume')->where('stock', '>', 0)->get();
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
            $inventario = Inventario::find($item['id']);
                //guardar detalle en la tabla detalle__venta
                Detalle_Venta::create([
                    'venta_id' => $venta->id,
                    'perfume_id' => $inventario->perfume_id,
                    'precio_unitario' => $item['precio'],
                    'cantidad' => $item['cantidad'],
                    'subtotal' => $item['precio'] * $item['cantidad'],
                    'empresa_id' => 1
                ]);

                //Actualizar stock en inventario
                $inventario = Inventario::find($item['id']);
                $inventario->stock -= $item['cantidad'];
                $inventario->save();
            }

            //Guardar si es a credito
            if($request->metodo_pago == 'credito'){
                Deuda::create([
                    'deuda_total' => $request->total,
                    'abonado' => 0,
                    'faltante' => $request->total,
                    'estatus' => $request->total == 0 ? 'pagada' : 'pendiente',
                    'cliente_id' => $request->cliente_id,
                    'venta_id' => $venta->id,
                    'empresa_id' => 1,
                    'user_id' => auth()->id()
                ]);
            }

            DB::commit();



        }catch(\Exception $e){
            DB::rollback();
            dd($e->getMessage());
        }

        return back()->with('success', 'Venta registrada exitosamente.');
    }
}
