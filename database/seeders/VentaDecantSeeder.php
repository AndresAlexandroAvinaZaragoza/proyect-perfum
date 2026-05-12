<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\InventarioDecants;

class VentaDecantSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 1000; $i++) {

            // 🔹 cliente random
            $cliente = Cliente::inRandomOrder()->first();

            // 🔹 producto decant random
            $inventarioDecant = InventarioDecants::with([
                'precioDecant',
                'decant'
            ])
            ->where('stock', '>', 0)
            ->inRandomOrder()
            ->first();

            if (!$inventarioDecant) {
                continue;
            }

            $tipoVenta = fake()->randomElement([
                'credito',
                'contado'
            ]);

            $precio = $inventarioDecant->precioDecant->precio;

            $cantidad = 1;

            $subtotal = $precio * $cantidad;

            // 🔥 crear venta
            $venta = Venta::create([

                'folio' => 'VTA-' . str_pad(
                    Venta::max('id') + 1,
                    5,
                    '0',
                    STR_PAD_LEFT
                ),

                'total' => $subtotal,

                'tipo_venta' => $tipoVenta,

                'pago_deuda' => null,

                'articulos' => 1,

                'cliente_id' => $cliente->id,

                'user_id' => 1,

                'empresa_id' => 1,
            ]);

            // 🔥 detalle venta decant
            DB::table('detalle_venta_decants')->insert([

                'ml' => $inventarioDecant->precioDecant->ml,

                'cantidad' => $cantidad,

                'precio_unitario' => $precio,

                'subtotal' => $subtotal,

                'venta_id' => $venta->id,

                'decant_id' => $inventarioDecant->decant_id,

                'inventario_decant_id' => $inventarioDecant->id,

                'empresa_id' => 1,

                'created_at' => now(),

                'updated_at' => now(),
            ]);

            // 🔥 descontar stock
            DB::table('inventario_decants')
                ->where('id', $inventarioDecant->id)
                ->decrement('stock', 1);

            // 🔥 si es crédito crear deuda
            if ($tipoVenta === 'credito') {

                DB::table('deudas')->insert([

                    'deuda_total' => $subtotal,

                    'abonado' => 0,

                    'faltante' => $subtotal,

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
}