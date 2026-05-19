<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Decant;
use App\Models\AbonoRegistro;

class VentaController extends Controller
{
    public function index(Request $request){

        $query = Venta::with(['cliente', 'usuario', 'perfume', 'inventario']);


        $clientes = Cliente::orderBy('nombre')->get();
        
        //cargamos la relacion inventario para mostrar solo los perfumes disponibles
        $inventarios = Inventario::with('perfume')->where('stock', '>', 0)->get();
        $decants = InventarioDecants::with('decant.perfume', 'precios_decants')->where('stock', '>', 0)->get();

        return view('principal.venta', compact('clientes', 'inventarios', 'decants'));
    }


    public function store(Request $request){
        DB::beginTransaction();

        try{

            $venta = Venta::create([
                'folio' => 'VTA-' . str_pad((Venta::max('id') ?? 0) + 1, 5, '0', STR_PAD_LEFT),
                'cliente_id' => $request->cliente_id,
                'total' => $request->total,
                'tipo_venta' => $request->metodo_pago,
                'articulos' => $request->articulos,
                'user_id' => auth()->id(),
                'empresa_id' => 1
            ]);

            $carrito = json_decode($request->carrito, true);

            foreach($carrito as $item){

                // PERFUMES
                if($item['tipo'] == 'perfume'){

                    $inventario = Inventario::findOrFail($item['id']);

                    //  VALIDAR STOCK
                    if($inventario->stock < $item['cantidad']){
                        throw new \Exception("Stock insuficiente para el perfume: ".$inventario->perfume->nombre);
                    }

                    Detalle_Venta::create([
                        'venta_id' => $venta->id,
                        'perfume_id' => $inventario->perfume_id,
                        'precio_unitario' => $item['precio'],
                        'cantidad' => $item['cantidad'],
                        'subtotal' => $item['precio'] * $item['cantidad'],
                        'empresa_id' => 1
                    ]);

                    // descontar stock
                    $inventario->stock -= $item['cantidad'];
                    $inventario->save();
                }


    
                //  DECANTS
                if($item['tipo'] == 'decant'){

                    $decant = InventarioDecants::findOrFail($item['id']);

                    // VALIDAR STOCK
                    if($decant->stock < $item['cantidad']){
                        throw new \Exception("Stock insuficiente para el decant");
                    }

                    DetalleVentaDecant::create([
                        'venta_id' => $venta->id,
                        'decant_id' => $decant->decant_id,
                        'inventario_decant_id' => $decant->id,
                        'ml' => $item['ml'],
                        'cantidad' => $item['cantidad'],
                        'precio_unitario' => $item['precio'],
                        'subtotal' => $item['precio'] * $item['cantidad'],
                        'empresa_id' => 1
                    ]);

                    // descontar stock
                    $decant->stock -= $item['cantidad'];
                    $decant->save();
                }
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

        //return back()->with('success', 'Venta registrada exitosamente.');
        return redirect()->route('venta.show', $venta->id)
            ->with('print_ticket', true);
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            // obtener venta
            $venta = Venta::with([
                'detalles',
                'detallesDecants'
            ])->findOrFail($id);

            // =====================================================
            // DEVOLVER STOCK DE PERFUMES
            // =====================================================
            
            foreach ($venta->detalles as $detalle) {
                $inventario = Inventario::where('perfume_id', $detalle->perfume_id)
                    ->first();
                if ($inventario) {
                    $inventario->increment('stock', $detalle->cantidad);
                }
            }

            // =====================================================
            // DEVOLVER STOCK DE DECANTS
            // =====================================================
            /*
            foreach ($venta->detallesDecants as $detalleDecant) {

                // devolver stock al inventario_decants
                $inventarioDecant = InventarioDecants::find(
                    $detalleDecant->inventario_decant_id
                );

                if ($inventarioDecant) {

                    $inventarioDecant->increment(
                        'stock',
                        $detalleDecant->cantidad
                    );
                }

                // devolver líquido al decant
                $decant = Decant::find($detalleDecant->decant_id);

                if ($decant) {

                    $decant->increment(
                        'cantidad_restante',
                        $detalleDecant->ml * $detalleDecant->cantidad
                    );
                }
            }
        */
            // =====================================================
            // ELIMINAR DEUDA SI EXISTE
            // =====================================================

            $deuda = Deuda::where('venta_id', $venta->id)->first();

            if ($deuda) {

                // eliminar abonos
                AbonoRegistro::where('deuda_id', $deuda->id)->delete();

                $deuda->delete();
            }

            // =====================================================
            // ELIMINAR DETALLES
            // =====================================================

            $venta->detalles()->delete();
            $venta->detallesDecants()->delete();

            // =====================================================
            // ELIMINAR VENTA
            // =====================================================

            $venta->delete();

            DB::commit();

            return redirect()
                ->route('venta.historial')
                ->with('success', 'Venta eliminada y stock restaurado correctamente.');

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Error al eliminar venta: ' . $e->getMessage());
        }
    }

    public function historial(Request $request){
        $query = Venta::with(['cliente', 'usuario', 'perfume', 'marca'])
        ->orderBy('created_at', 'desc');

        if ($request->search) {

        $query->where(function($q) use ($request) {
                $q->where('folio', 'like', '%' . $request->search . '%')
                ->orWhereHas('cliente', function($q2) use ($request) {
                    $q2->where('nombre', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('perfume', function($q2) use ($request) {
                    $q2->where('nombre', 'like', '%' . $request->search . '%');
                });
            });
        }
        
        if ($request->tipo_venta) {
            $query->where('tipo_venta', $request->tipo_venta);
        }

        //Filtro de Rango
        if ($request->rango) {

            switch ($request->rango) {

                case 'ayer':
                    $inicio = Carbon::yesterday()->startOfDay();
                    $fin = Carbon::yesterday()->endOfDay();
                    break;

                case 'semana':
                    $inicio = Carbon::now()->subDays(7)->startOfDay();
                    $fin = Carbon::now()->endOfDay();
                    break;

                case 'mes':
                    $inicio = Carbon::now()->subMonth()->startOfDay();
                    $fin = Carbon::now()->endOfDay();
                    break;

                case '6meses':
                    $inicio = Carbon::now()->subMonths(6)->startOfDay();
                    $fin = Carbon::now()->endOfDay();
                    break;

                default:
                    $inicio = null;
                    $fin = null;
            }

            if ($inicio && $fin) {
                $query->whereBetween('created_at', [$inicio, $fin]);
            }
        }

        $marcas = Marca::orderBy('nombre')->get();
        $ventas = $query->paginate(10)->withQueryString();
        return view('principal.historialVenta', compact('ventas', 'marcas'));
    }


    public function show($id)
    {
        $venta = Venta::with([
            'cliente',
            'usuario',
            'detalles.perfume', // importante para la tabla
            'detallesDecants.decant.perfume' // importante para la tabla
        ])->findOrFail($id);

        return view('principal.detalle_venta', compact('venta'));
    }

    public function pdf($id)
    {
        $venta = Venta::with([
            'cliente',
            'usuario',
            'detalles.perfume',
            'detallesDecants.decant.perfume'
        ])->findOrFail($id);

        $pdf = Pdf::loadView('pdf.venta', compact('venta'));

        return $pdf->download('venta_'.$venta->id.'.pdf');
    }
    public function ticket($id)
    {
        $venta = Venta::with([
            'cliente',
            'usuario',
            'detalles.perfume',
            'detallesDecants.decant.perfume'

        ])->findOrFail($id);

        $pdf = Pdf::loadView('pdf.ticket', compact('venta'))
                ->setPaper([0,0,226.77,600], 'portrait'); // tamaño ticket

        return $pdf->stream('ticket_'.$venta->id.'.pdf');
    }
}
