<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Inventario;

class SoloDecantsSeeder extends Seeder
{
    public function run(): void
    {
        $inventarios = Inventario::where('stock', '>', 0)
            ->inRandomOrder()
            ->take(500)
            ->get();

        foreach ($inventarios as $inventario) {

            $perfume = DB::table('perfumes')
                ->where('id', $inventario->perfume_id)
                ->first();

            if (!$perfume) continue;

            $precioBotella = $inventario->precio_venta;

            $ml = $perfume->contenido;

            if ($ml <= 0) continue;

            $precioPorMl = $precioBotella / $ml;

            DB::table('decants')->insert([

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
        }
    }
}