<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Inventario;

class DecantSeeder extends Seeder
{
    public function run(): void
    {
        $inventarios = Inventario::where('stock', '>', 0)->inRandomOrder()->take(500) ->get();
        foreach ($inventarios as $inventario) {

            // 🔹 obtener perfume
            $perfume = DB::table('perfumes')->where('id', $inventario->perfume_id)->first();

            if (!$perfume) continue;

            // 🔹 calcular precio por ml
            $precioBotella = $inventario->precio_venta;
            $ml = $perfume->contenido;

            if ($ml == 0) continue;

            $precioPorMl = $precioBotella / $ml;

            // 🔹 crear decant
            
            $decantId = DB::table('decants')->insertGetId([
                'cantidad_restante' => $ml,
                'precio_por_ml' => $precioPorMl,
                'precio_botella' => $precioBotella,
                'inventario_id' => $inventario->id,
                'perfume_id' => $perfume->id,
                'user_id' => 1,
                'empresa_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 🔥 precios por ml (como tu BD)
            $mlOpciones = [1, 2, 3, 5, 10, 30];

            foreach ($mlOpciones as $mlValor) {

                $precio = round($precioPorMl * $mlValor);

                $precioDecantId = DB::table('precios_decants')->insertGetId([
                    'ml' => $mlValor,
                    'precio' => $precio,
                    'decant_id' => $decantId,
                    'empresa_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // 🔹 inventario decant
                DB::table('inventario_decants')->insert([
                    'decant_id' => $decantId,
                    'precio_decant_id' => $precioDecantId,
                    'stock' => rand(0, 5),
                    'user_id' => 1,
                    'empresa_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}