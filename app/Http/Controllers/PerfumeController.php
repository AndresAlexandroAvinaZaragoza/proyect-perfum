<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Marca;
use App\Models\Perfume;
use Illuminate\Http\Request;

class PerfumeController extends Controller
{
    public function index(Request $request)
    {
        $query = Perfume::with(['marca','usuario']);

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

        $perfumes = $query->paginate(10)->withQueryString();

        $marcas = Marca::orderBy('nombre','asc')->get();

        return view('principal.perfume', compact('perfumes','marcas'));
    }
    //funcion para traer los datos de marca
    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    //funcion para traer los datos de usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'usuario');
    }

    public function store(Request $request){
        $request->validate([
            'nombre' => 'required|max:100'
        ]);

        $perfume = new Perfume();


        $perfume->nombre = $request->nombre;
        $perfume->contenido = $request->contenido;
        $perfume->marca_id = $request->marca_id;
        $perfume->concentracion = $request->concentracion;
        $perfume->tipo = $request->tipo;
        $perfume->genero = $request->genero;
        $perfume->categoria = $request->categoria;

        $perfume->user_id = auth()->id();
        $perfume->empresa_id = 1;

        $perfume->save();

        return redirect()->back()->with('success', 'Perfume registrado correctamente');

    }
    

    public function update(Request $request, $id){
        $perfume = Perfume::find($id);
        $perfume->nombre = $request->nombre;
        $perfume->contenido = $request->contenido;
        $perfume->concentracion = $request->concentracion;
        $perfume->tipo = $request->tipo;
        $perfume->genero = $request->genero;
        $perfume->categoria = $request->categoria;
        $perfume->marca_id = $request->marca_id;

        $perfume->save();
        return redirect()->back()->with('success', 'Perfume actualizada correctamente');
    }

    public function destroy($id){
        $perfume = Perfume::findOrFail($id);

        $perfume->delete();
        return redirect()->back()->with('success', 'Marca eliminada correctamente');
    }

}

