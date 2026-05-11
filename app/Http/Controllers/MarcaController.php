<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Marca;
use App\MOdels\Perfume;
use Illuminate\Http\Request;

class MarcaController extends Controller
{

    public function index(Request $request)
    {
        $query = Marca::with('usuario')->orderBy('nombre','asc');

        $query = Marca::with('usuario')->orderBy('nombre','asc');

        if ($request->search) {
            $query->where(function($q) use ($request) {

                $q->where('nombre','like','%'.$request->search.'%')
                ->orWhere('pais_origen','like','%'.$request->search.'%');

                // BUSCAR FECHA
                try {
                    $fecha = Carbon::createFromFormat('d/m/Y', $request->search)->format('Y-m-d');

                    $q->orWhereDate('created_at', $fecha);
                } catch (\Exception $e) {
                    // si no es fecha válida, no hace nada
                }

                // BUSCAR USUARIO POR NOMBRE
                $q->orWhereHas('usuario', function($q2) use ($request) {
                    $q2->where('usuario','like','%'.$request->search.'%');
                });

            });
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
