<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Perfume;
use Illuminate\Support\Facades\DB;

class VentaSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 1000; $i++) {

            // 🔹 cliente aleatorio
            $cliente = Cliente::inRandomOrder()->first();

            // 🔹 generar folio
            $numeroVenta = (Venta::max('id') ?? 0) + 1;

            $folio = 'VTA-' . str_pad(
                $numeroVenta,
                5,
                '0',
                STR_PAD_LEFT
            );

            // 🔹 crear venta vacía primero
            $venta = Venta::create([
                'folio' => $folio,

                'total' => 0,
                'tipo_venta' => 'credito',
                'pago_deuda' => null,
                'articulos' => 0,
                'cliente_id' => $cliente->id,
                'user_id' => 1,
                'empresa_id' => 1,
            ]);

            $total = 0;
            $totalArticulos = 0;

            // 🔹 seleccionar perfumes aleatorios
            $perfumes = Perfume::inRandomOrder()
                ->take(rand(1, 5))
                ->get();

            foreach ($perfumes as $perfume) {

                $cantidad = 1;

                // 🔹 sacar precio desde inventario
                $inventario = DB::table('inventarios')
                    ->where('perfume_id', $perfume->id)
                    ->first();

                if (!$inventario) {
                    continue;
                }

                $precio = $inventario->precio_venta;

                $subtotal = $precio * $cantidad;

                // 🔹 insertar detalle
                DB::table('detalle__ventas')->insert([

                    'cantidad' => $cantidad,

                    'precio_unitario' => $precio,

                    'subtotal' => $subtotal,

                    'venta_id' => $venta->id,

                    'perfume_id' => $perfume->id,

                    'empresa_id' => 1,

                    'created_at' => now(),

                    'updated_at' => now(),
                ]);

                $total += $subtotal;

                $totalArticulos += $cantidad;
            }

            // 🔹 actualizar venta con total real
            $venta->update([
                'total' => $total,
                'articulos' => $totalArticulos,
            ]);

            // 🔹 crear deuda automáticamente
            DB::table('deudas')->insert([

                'deuda_total' => $total,

                'abonado' => 0,

                'faltante' => $total,

                'estatus' => 'pendiente',

                'cliente_id' => $cliente->id,

                'venta_id' => $venta->id,

                'empresa_id' => 1,

                'user_id' => 1,

                'created_at' => now(),

                'updated_at' => now(),
            ]);
        }
    }
}