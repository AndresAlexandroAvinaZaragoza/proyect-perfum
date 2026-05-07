<?php

namespace App\Http\Controllers;

use App\Models\Pedidos;
use App\Models\DetallePedido;
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
use Illuminate\Database\QueryException;
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




    public function store(Request $request)
    {
        //  dd($request->all());
        // VALIDACIÓN
        $request->validate([
            'selectProovedores' => 'required|exists:proovedores,id',
            'numero_guia' => 'nullable|numeric',
            'paqueteria' => 'required|string|max:50',
            'carrito' => 'required'
        ]);

        // DECODIFICAR CARRITO
        $carrito = json_decode($request->carrito, true);

        if(empty($carrito)){
            return back()->with('error', 'El carrito está vacío');
        }

        DB::beginTransaction();

        try {

            // CREAR PEDIDO
            $pedido = null;
            $maxAttempts = 3;

            for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
                try {
                    $pedido = Pedidos::create([
                        'folio' => $this->generateNextFolio(),
                        'guia' => $request->numero_guia,
                        'precio_envio' => is_numeric($request->envio) ? $request->envio : ($request->precio_envio ?? 0),
                        'paqueteria' => $request->paqueteria,
                        'total' => is_numeric($request->total) ? $request->total : 0,
                        'proovedor_id' => $request->selectProovedores,
                        'user_id' => auth()->id(),
                        'empresa_id' => 1
                    ]);

                    break;
                } catch (QueryException $e) {
                    $isDuplicateFolio = $e->getCode() === '23000'
                        && str_contains($e->getMessage(), 'pedidos_folio_unique');

                    if (!$isDuplicateFolio || $attempt === $maxAttempts) {
                        throw $e;
                    }
                }
            }

            // DETALLES
            foreach($carrito as $item){

                // validar seguridad
                if(!isset($item['id']) || !isset($item['cantidad'])){
                    continue;
                }

                DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'perfume_id' => $item['id'],
                    'cantidad' => $item['cantidad'],
                    'precio_de_compra' => $item['precio'] ?? 0,
                    'empresa_id' => 1
                ]);

            }

            DB::commit();

            return redirect()
                ->route('pedidos.index')
                ->with('success', 'Pedido guardado correctamente');

        } catch (\Exception $e) {


            DB::rollBack();
            dd($e->getMessage());
            
        }
    }

    public function detallePedidos(Request $request)
    {
        $query = Pedidos::with(['detalles.perfume', 'proovedor', 'usuario'])
                        ->orderBy('created_at', 'desc');

        if ($request->search) {
            $query->where(function($q) use ($request){

                $q->where('folio','like','%'.$request->search.'%')
                ->orWhere('guia','like','%'.$request->search.'%')
                ->orWhere('paqueteria','like','%'.$request->search.'%');

                // PROOVEDOR
                $q->orWhereHas('proovedor', function($q2) use ($request) {
                    $q2->where('nombre','like','%'.$request->search.'%');
                });

                // USUARIO
                $q->orWhereHas('usuario', function($q2) use ($request) {
                    $q2->where('name','like','%'.$request->search.'%'); // probablemente es 'name'
                });
            });
        }

        $pedidos = $query->paginate(10)->withQueryString();

        return view('principal.detallePedidos', compact('pedidos'));
    }

    public function show($id)
    {
        $pedido = Pedidos::with(['detalles.perfume', 'proovedor', 'usuario'])->findOrFail($id);
        return view('principal.detalleP', compact('pedido'));
    }

    public function edit($id)
    {
        $pedido = Pedidos::with('detalles')->findOrFail($id);
        $perfumes = Perfume::all();
        $proovedores = Proovedor::all();

        return view('principal.editarPedido', compact('pedido','perfumes','proovedores'));
    }

    public function update(Request $request, $id)
    {
        // VALIDACIÓN
        $request->validate([
            'selectProovedores' => 'required|exists:proovedores,id',
            'numero_guia'       => 'nullable|numeric',
            'paqueteria'        => 'required|string|max:50',
            'carrito'           => 'required',
        ]);

        // DECODIFICAR CARRITO
        $carrito = json_decode($request->carrito, true);

        if (empty($carrito)) {
            return back()->with('error', 'El carrito está vacío');
        }

        DB::beginTransaction();

        try {

            // BUSCAR PEDIDO
            $pedido = Pedidos::findOrFail($id);

            // ACTUALIZAR DATOS GENERALES
            $pedido->update([
                'guia'         => $request->numero_guia,
                'precio_envio' => is_numeric($request->envio) ? $request->envio : ($request->precio_envio ?? 0),
                'paqueteria'   => $request->paqueteria,
                'total'        => is_numeric($request->total) ? $request->total : 0,
                'proovedor_id' => $request->selectProovedores,
            ]);

            // ELIMINAR DETALLES ANTERIORES Y RECREAR
            $pedido->detalles()->delete();

            foreach ($carrito as $item) {

                if (!isset($item['id']) || !isset($item['cantidad'])) {
                    continue;
                }

                DetallePedido::create([
                    'pedido_id'        => $pedido->id,
                    'perfume_id'       => $item['id'],
                    'cantidad'         => $item['cantidad'],
                    'precio_de_compra' => $item['precio'] ?? 0,
                    'empresa_id'       => 1,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('pedidos.detallePedidos')
                ->with('success', 'Pedido actualizado correctamente');

        } catch (\Exception $e) {

            DB::rollBack();
            dd($e->getMessage());
        }
    }

    public function estado(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,enviado,recibido,cancelado'
        ]);

        $pedido = Pedidos::findOrFail($id);
        $pedido->estado = $request->estado;
        $pedido->save();

        return back()->with('success', 'Estado del pedido actualizado correctamente');
    }



    public function destroy($id)
    {
        $pedido = Pedidos::findOrFail($id);
        $pedido->delete();

        return back()->with('success', 'Pedido eliminado correctamente');
    }

    private function generateNextFolio(): string
    {
        $lastFolio = Pedidos::where('folio', 'like', 'PED-%')
            ->lockForUpdate()
            ->orderByDesc('folio')
            ->value('folio');

        $lastNumber = 0;
        if ($lastFolio) {
            $lastNumber = (int) str_replace('PED-', '', $lastFolio);
        }

        return 'PED-' . str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
    }

    public function pdf($id)
    {
        $pedido = Pedidos::with(['detalles.perfume', 'proovedor', 'usuario'])->findOrFail($id);
        $pdf = Pdf::loadView('pdf.pedido', compact('pedido'));
        return $pdf->download('pedido_' . $pedido->folio . '.pdf');
    }
}

