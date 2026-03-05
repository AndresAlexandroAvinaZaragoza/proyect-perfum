<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\MOdels\Perfume;
use Illuminate\Http\Request;

class MarcaController extends Controller
{

    public function index(Request $request)
    {
        $query = Marca::query();

        //if para el buscador 
        if ($request->filled('search') && $request->filled('filter')) {

            if ($request->filter == 'fecha') {
                $query->whereDate('created_at', $request->search);
            } else {
                $query->where($request->filter, 'like', '%' . $request->search . '%');
            }
        }

        //Ordenamiento por nombre, fecha, pais o vocal
        if ($request->orden == 'az') {
            $query->orderBy('nombre', 'asc');
        } else {
            $query->orderBy('id', 'desc');
        }

        $marcas = $query->paginate(10)->withQueryString();

        return view('principal.marca', compact('marcas'));
    }
    

    public function create()
    {
        //
    }


   public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'pais_origen' => 'required|max:30',
        ]);

        $marca = new Marca();

        $marca->nombre = $request->nombre;
        $marca->pais_origen = $request->pais_origen;

        // Nombres correctos segun la migracion
        $marca->usuario_id = auth()->id();
        $marca->empresa_id = 1; // si existe en users
        $marca->registro_fecha = now();

        $marca->save();

        return redirect()->back()->with('success', 'Marca registrada correctamente');
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)

    {
        $marca = Marca::find($id);
        $marca->nombre = $request->nombre;
        $marca->pais_origen = $request->pais_origen;

        $marca->save();

        return redirect()->back()->with('success', 'Marca actualizada correctamente');
    }

    public function destroy($id)
    {
        $marca = Marca::findOrFail($id);

        $marca->delete();
        return redirect()->back()->with('success', 'Marca eliminada correctamente');
    }
    
    public function perfumes()
    {
        return $this->hasMany(Perfume::class);
    }

}
