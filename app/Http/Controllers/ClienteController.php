<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\User;
class ClienteController extends Controller
{
    public function index(Request $request){

        $query = Cliente::with(['usuario']);
        
        if($request->search){
            $query->where('nombre','like','%'.$request->search.'%');
        }

        $clientes = $query->paginate(10)->withQueryString();
        
        return view('principal.cliente', compact('clientes'));
    }    

    public function store(Request $request){
        $request->validate([
            'nombre' => 'required|max:100',
            'celular' => 'required|max:15',
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
}
