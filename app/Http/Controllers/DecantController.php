<?php

namespace App\Http\Controllers;

use App\Models\PrecioDecant;
use App\Models\Empresa;
use App\Models\User;
use App\Models\Perfume;
use App\Models\Inventario;
use App\Models\Decant;
use App\Models\InventarioDecants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DecantController extends Controller
{
    public function index(Request $request)
    {
        $query = Decant::with(['perfume', 'inventario']);

        // =========================
        // BUSCADOR
        // =========================
        if ($request->filled('search')) {

            $search = $request->search;

            $query->whereHas('perfume', function ($q) use ($search) {

                $q->where('nombre', 'like', '%' . $search . '%');

            });
        }

        // =========================
        // FILTRO POR PORCENTAJE
        // =========================
        if ($request->filled('porcentaje')) {

            $porcentaje = (int) $request->porcentaje;

            $query->whereHas('perfume', function ($q) use ($porcentaje) {

                // contenido original del perfume
                $q->select('id', 'contenido');

            });

            if ($porcentaje == 25) {

                $query->whereRaw('
                    (
                        (cantidad_restante * 100) /
                        (
                            SELECT perfumes.contenido
                            FROM perfumes
                            WHERE perfumes.id = decants.perfume_id
                        )
                    ) BETWEEN 0 AND 25
                ');

            } elseif ($porcentaje == 50) {

                $query->whereRaw('
                    (
                        (cantidad_restante * 100) /
                        (
                            SELECT perfumes.contenido
                            FROM perfumes
                            WHERE perfumes.id = decants.perfume_id
                        )
                    ) BETWEEN 26 AND 50
                ');

            } elseif ($porcentaje == 75) {

                $query->whereRaw('
                    (
                        (cantidad_restante * 100) /
                        (
                            SELECT perfumes.contenido
                            FROM perfumes
                            WHERE perfumes.id = decants.perfume_id
                        )
                    ) BETWEEN 51 AND 75
                ');09,099

            } elseif ($porcentaje == 100) {

                $query->whereRaw('
                    (
                        (cantidad_restante * 100) /
                        (
                            SELECT perfumes.contenido
                            FROM perfumes
                            WHERE perfumes.id = decants.perfume_id
                        )
                    ) BETWEEN 76 AND 100
                ');
            }
        }

        // PAGINACIÓN
        $decants = $query->paginate(8)->withQueryString();

        // INVENTARIOS
        $inventarios = Inventario::with('perfume')
            ->where('stock', '>', 0)
            ->whereHas('perfume', function($q){
                $q->where('tipo', 'Perfume');
            })
            ->get();

        return view('principal.decant', compact('decants', 'inventarios'));
    }


    public function store(Request $request)
    {   

        try{

            $request->validate([
                'inventario_id' => 'required|exists:inventarios,id',
                'precio_1ml' => 'required|numeric|min:0|max:9999.99',
                'precio_2ml' => 'required|numeric|min:0|max:9999.99',
                'precio_3ml' => 'required|numeric|min:0|max:9999.99',
                'precio_5ml' => 'required|numeric|min:0|max:9999.99',
                'precio_10ml' => 'required|numeric|min:0|max:9999.99',
                'precio_30ml' => 'required|numeric|min:0|max:9999.99',
            ]);

            // VALIDAR QUE EL DECANT BASE NO EXISTA PARA EL MISMO PERFUME
            $existingDecant = Decant::where('perfume_id', $request->inventario_id)->first();
            if ($existingDecant) {
                return redirect()->back()->with('error', 'Ya existe un decant base para este perfume.');
            }

            $decant = new Decant();
            // Buscar el inventario
            $inventario = Inventario::findOrFail($request->inventario_id);

            // Obtener precio de compra desde el inventario de BD   
            $precioCompra = $inventario->precio_compra;
            $contenido = $inventario->perfume->contenido;
            $inventario_id = $inventario->perfume->id;

            $decant->inventario_id = $request->inventario_id;
            $decant->precio_botella = $precioCompra;
            $decant->cantidad_restante = $contenido;
            $decant->perfume_id = $inventario_id;
            $decant->user_id = auth()->id();
            $decant->empresa_id = 1;
            $decant->save();

            // Guardar precios en la tabla precios decants

            // Arreglo de precios desde el form
            $precios = [
                1 => $request->precio_1ml,
                2 => $request->precio_2ml,
                3 => $request->precio_3ml,
                5 => $request->precio_5ml,
                10 => $request->precio_10ml,
                30 => $request->precio_30ml,
            ];

            foreach ($precios as $ml => $precio) {
                if ($precio > 0) {
                    DB::table('precios_decants')->insert([
                        'ml' => $ml,
                        'precio' => $precio,
                        'decant_id' => $decant->id,
                        'empresa_id' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

        }catch(\Exception $e){
            DB::rollBack();
            Log::error('Error al registrar decant base', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'No se pudo registrar el decant base.');
        }
        
        return redirect()->back()->with('success', 'Decant registrado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        try {

            DB::beginTransaction();

            // VALIDACIONES
            $request->validate([
                'precio_1ml' => 'required|numeric|min:0|max:9999.99',
                'precio_2ml' => 'required|numeric|min:0|max:9999.99',
                'precio_3ml' => 'required|numeric|min:0|max:9999.99',
                'precio_5ml' => 'required|numeric|min:0|max:9999.99',
                'precio_10ml' => 'required|numeric|min:0|max:9999.99',
                'precio_30ml' => 'required|numeric|min:0|max:9999.99',
            ]);

            // BUSCAR DECANT
            $decant = Decant::findOrFail($id);

            // ACTUALIZAR PRECIOS
            $precios = [
                1 => $request->precio_1ml,
                2 => $request->precio_2ml,
                3 => $request->precio_3ml,
                5 => $request->precio_5ml,
                10 => $request->precio_10ml,
                30 => $request->precio_30ml,
            ];

            foreach ($precios as $ml => $precio) {

                $precioExistente = PrecioDecant::where('decant_id', $decant->id)
                    ->where('ml', $ml)
                    ->first();

                if ($precioExistente) {

                    // ACTUALIZAR
                    $precioExistente->precio = $precio;
                    $precioExistente->updated_at = now();
                    $precioExistente->save();

                } else {

                    // CREAR SI NO EXISTE
                    PrecioDecant::create([
                        'ml' => $ml,
                        'precio' => $precio,
                        'decant_id' => $decant->id,
                        'empresa_id' => 1,
                    ]);
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Decant actualizado correctamente.');

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Error al actualizar decant', [
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'No se pudo actualizar el decant.');
        }
    }

    public function generarDecant(Request $request)
{
    try {

        //  Obtener datos del form
        $decant = Decant::findOrFail($request->decant_id);
        $ml = (int) $request->tamano_decant;
        $cantidad = (int) $request->cantidad_generar;

        // Validación
        if ($ml <= 0 || $cantidad <= 0) {
            return back()->withErrors('Datos inválidos');
        }

        //  Calcular extracción
        $extraccionTotal = $ml * $cantidad;

        if ($decant->cantidad_restante < $extraccionTotal) {
            return back()->withErrors('No hay suficiente líquido');
        }



        //  Buscar precio
        $precioDecant = PrecioDecant::where('decant_id', $decant->id)
            ->where('ml', $ml)
            ->first();

        if (!$precioDecant) {
            return back()->with('error', 'No existe un precio configurado para ese tamaño de decant.');
        }

        //  Verificar si ya existe
        $inventarioExistente = InventarioDecants::where('decant_id', $decant->id)
            ->where('precio_decant_id', $precioDecant->id)
            ->first();

        if ($inventarioExistente) {
            // SUMAR
            $inventarioExistente->stock += $cantidad;
            $inventarioExistente->save();
        } else {
            //  CREAR
            InventarioDecants::create([
                'decant_id' => $decant->id,
                'precio_decant_id' => $precioDecant->id,
                'stock' => $cantidad,
                'user_id' => auth()->id(),
                'empresa_id' => 1
            ]);
        }

        return back()->with('success', 'Decants generados correctamente');

    } catch (\Throwable $e) {
        Log::error('Error al generar inventario de decants', [
            'error' => $e->getMessage()
        ]);

        return back()->with('error', $e->getMessage());
    }
}

    public function rellenar(Request $request)
    {
        try {
            $request->validate([
                'decant_id' => 'required|exists:decants,id',
                'botellas' => 'required|integer|min:1'
            ]);

            $decant = Decant::findOrFail($request->decant_id);

            $botellas = (int) $request->botellas;

            // total disponibles en inventario para ese perfume
            $totalDisponibles = Inventario::where('perfume_id', $decant->perfume_id)->sum('stock');

            if ($totalDisponibles < $botellas) {
                return back()->with('error', 'No hay suficientes frascos en inventario para rellenar.');
            }

            // descontar botellas del inventario (desde los registros más antiguos)
            $restar = $botellas;
            $inventarios = Inventario::where('perfume_id', $decant->perfume_id)
                ->where('stock', '>', 0)
                ->orderBy('id', 'asc')
                ->get();

            foreach ($inventarios as $inv) {
                if ($restar <= 0) break;

                if ($inv->stock <= $restar) {
                    $restar -= $inv->stock;
                    $inv->stock = 0;
                } else {
                    $inv->stock -= $restar;
                    $restar = 0;
                }

                $inv->save();
            }

            // sumar ml al decant
            $mlPorBotella = $decant->perfume->contenido ?? 0;
            $mlSumar = $mlPorBotella * $botellas;

            $decant->cantidad_restante = ($decant->cantidad_restante ?? 0) + $mlSumar;
            $decant->save();

            return back()->with('success', 'Decant rellenado correctamente. Se consumieron ' . $botellas . ' frascos del inventario.');

        } catch (\uThrowable $e) {
            Log::error('Error al rellenar decant', ['error' => $e->getMessage()]);
            return back()->with('error', 'Ocurrió un error al intentar rellenar.');
        }
    }

    public function destroy($id)
    {
        try {
            $decant = Decant::findOrFail($id);
            $decant->delete();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'No se pudo eliminar el decant.');
        }

        return redirect()->back()->with('success', 'Decant eliminado exitosamente.');
    }
}
