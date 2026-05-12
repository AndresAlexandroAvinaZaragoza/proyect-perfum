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
            'nombre' => 'required|max:100|unique:proovedores,nombre',
            'celular' => 'required|min:10|max:15|unique:proovedores,celular',
            'correo' => 'required|max:100|unique:proovedores,correo'
        ],[
            'celular.min' => 'El número de celular debe tener al menos 10 caracteres',
            'nombre.unique' => 'Ya existe un proveedor con ese nombre',
            'celular.unique' => 'Ya existe un proveedor con ese número de celular',
            'correo.unique' => 'Ya existe un proveedor con ese correo electrónico'
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
        $request->validate([
            'nombre' => 'required|max:100|unique:proovedores,nombre,' . $id,
            'celular' => 'required|min:10|max:15|unique:proovedores,celular,' . $id,
            'correo' => 'required|max:100|unique:proovedores,correo,' . $id
        ],[
            'celular.min' => 'El número de celular debe tener al menos 10 caracteres',
            'nombre.unique' => 'Ya existe un proveedor con ese nombre',
            'celular.unique' => 'Ya existe un proveedor con ese número de celular',
            'correo.unique' => 'Ya existe un proveedor con ese correo electrónico'
        ]);

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
