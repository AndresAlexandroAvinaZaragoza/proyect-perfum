<?php


namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Proovedor;
use Illuminate\Http\Request;

class ProovedorController extends Controller
{
    public function index(Request $request){
        $query = Proovedor::with(['usuario']);

        if($request->search){
            $query->where(function($q) use ($request){
                $q->where('nombre','like','%'.$request->search.'%')
                ->orWhere('celular','like','%'.$request->search.'%')
                ->orWhere('correo','like','%'.$request->search.'%');
                
                // BUSCAR USUARIO POR NOMBRE
                $q->orWhereHas('usuario', function($q2) use ($request) {
                    $q2->where('usuario','like','%'.$request->search.'%');
                });
            });
        }

        $proovedores = $query->paginate(10)->withQueryString();

        return view('principal.proovedor', compact('proovedores'));
    }

    
    public function store(Request $request){
        $request->validate([
            'nombre' => 'required|max:100',
            'celular' => 'required|max:15',
            'correo' => 'required|max:100'
        ]);
        
        $proovedor = new Proovedor();
        
        $proovedor->nombre = $request->nombre;
        $proovedor->celular = $request->celular;
        $proovedor->correo = $request->correo;

        $proovedor->user_id = auth()->id();
        $proovedor->empresa_id = 1;

        $proovedor->save();

        return redirect()->back()->with('success', 'Proveedor registrado correctamente');

    }

    public function update(Request $request, $id){
        $proovedor = Proovedor::find($id);

        $proovedor->nombre = $request->nombre;
        $proovedor->celular = $request->celular;
        $proovedor->correo = $request->correo;


        $proovedor->save();

        return redirect()->back()->with('success', 'Proveedor editado correctamente');

    }



    public function destroy($id){
        $proovedor = Proovedor::findOrFail($id);

        $proovedor->delete();
        return redirect()->back()->with('success', 'Proveedor eliminado correctamente');
    }
}
