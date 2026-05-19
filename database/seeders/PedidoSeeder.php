<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pedido;
use App\Models\Proovedor;
use App\Models\Perfume;
use Illuminate\Support\Facades\DB;

class PedidoSeeder extends Seeder
{
    public function run(): void
    {
        // obtener último ID actual
        $ultimoId = Pedido::max('id') ?? 0;

        for ($i = 1; $i <= 500; $i++) {

            // 🔹 proveedor random
            $proveedor = Proovedor::inRandomOrder()->first();

            //  crear pedido
            $pedido = Pedido::create([

                'folio' => 'PED-' . str_pad(
                    $ultimoId + $i,
                    5,
                    '0',
                    STR_PAD_LEFT
                ),

                'estado' => fake()->randomElement([
                    'pendiente',
                    'recibido'
                ]),

                'guia' => fake()->numerify('###########'),

                'precio_envio' => fake()->numberBetween(100, 400),

                'paqueteria' => fake()->randomElement([
                    'DHL',
                    'Estafeta',
                    'FedEx'
                ]),

                'total' => 0,

                'proovedor_id' => $proveedor->id,

                'user_id' => 1,

                'empresa_id' => 1,
            ]);

            $total = 0;

            // perfumes random
            $perfumes = Perfume::inRandomOrder()
                ->take(rand(1, 5))
                ->get();

            foreach ($perfumes as $perfume) {

                $cantidad = rand(1, 5);

                $precioCompra = rand(500, 2500);

                $subtotal = $cantidad * $precioCompra;

                //  detalle pedido
                DB::table('detalle_pedidos')->insert([

                    'cantidad' => $cantidad,

                    'precio_de_compra' => $precioCompra,

                    'pedido_id' => $pedido->id,

                    'perfume_id' => $perfume->id,

                    'empresa_id' => 1,

                    'created_at' => now(),

                    'updated_at' => now(),
                ]);

                $total += $subtotal;
            }

            //  sumar envío al total
            $totalFinal = $total + $pedido->precio_envio;

            //  actualizar total pedido
            $pedido->update([
                'total' => $totalFinal
            ]);
        }
    }
}