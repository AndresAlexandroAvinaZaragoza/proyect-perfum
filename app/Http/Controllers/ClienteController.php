<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\User;
use App\Models\Deuda;
use Carbon\Carbon;
use App\Models\DetalleVentaDecant;
use App\Models\InventarioDecants;
use App\Models\Marca;
use Illuminate\Support\Facades\DB;
use App\Models\Detalle_Venta;
use App\Models\Perfume;
use App\Models\Inventario;
use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Decant;
use App\Models\AbonoRegistro;

class ClienteController extends Controller
{
    public function index(Request $request){

        $query = Cliente::with(['usuario']);
        
        if($request->search){
            $query->where(function($q) use ($request){
                $q->where('nombre','like','%'.$request->search.'%')
                ->orWhere('celular','like','%'.$request->search.'%');
                
                // BUSCAR USUARIO POR NOMBRE
                $q->orWhereHas('usuario', function($q2) use ($request) {
                    $q2->where('usuario','like','%'.$request->search.'%');
                });
            });
        }

        $clientes = $query->paginate(10)->withQueryString();
        
        return view('principal.cliente', compact('clientes'));
    }    

    public function store(Request $request){
        $request->validate([
            'nombre' => 'required|max:100|unique:clientes,nombre',
            'celular' => 'required|min:10|max:15|unique:clientes,celular',
        ],[
            'celular.min' => 'El número de celular debe tener al menos 10 caracteres',
            'nombre.unique' => 'Ya existe un cliente con ese nombre',
            'celular.unique' => 'Ya existe un cliente con ese número de celular',
        ]);

        $cliente = new Cliente();

        $cliente->nombre = $request->nombre;
        $cliente->celular = $request->celular;

        $cliente->user_id = auth()->id();
        $cliente->empresa_id = 1;

        $cliente->save();

        return redirect()->back()->with('success', 'Cliente registrado correctamente');



    }

        public function update(Request $request, $id){

        $request->validate([
            'nombre' => 'required|max:100|unique:clientes,nombre,' . $id,
            'celular' => 'required|min:10|max:15|unique:clientes,celular,' . $id,
        ],[
            'celular.min' => 'El número de celular debe tener al menos 10 caracteres',
            'nombre.unique' => 'Ya existe un cliente con ese nombre',
            'celular.unique' => 'Ya existe un cliente con ese número de celular',
        ]);

        $cliente = Cliente::find($id);

        $cliente->nombre = $request->nombre;
        $cliente->celular = $request->celular;
        


        $cliente->save();

        return redirect()->back()->with('success', 'Cliente editado correctamente');

    }



    public function destroy($id){
        $cliente = Cliente::findOrFail($id);

        $cliente->delete();
        return redirect()->back()->with('success', 'Cliente eliminada correctamente');
    }

    public function show(Request $request, $id)
    {
        // cliente
        $cliente = Cliente::with('usuario')
            ->findOrFail($id);

        // query de deudas SOLO de este cliente
        $query = Deuda::with([
                'venta',
                'ultimoAbono.usuario'
            ])
            ->where('cliente_id', $id);

        //  SEARCH
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                // buscar por folio
                $q->whereHas('venta', function ($q2) use ($search) {

                    $q2->where('folio', 'like', "%{$search}%");

                });

            });
        }

        // FILTROS
        if ($request->filled('estatus')) {

            switch ($request->estatus) {

                case 'completado':

                    $query->where('estatus', 'Pagada');

                    break;

                case 'en_progreso':

                    $query->where('estatus', 'pendiente')
                        ->where('abonado', '>', 0);

                    break;

                case 'atrasado':

                    $query->where('estatus', 'pendiente')
                        ->where('abonado', 0);

                    break;
            }
        }

        $deudas = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'principal.deudaCliente',
            compact('cliente', 'deudas')
        );
    }
}
