<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pedido;
use App\Models\Proovedor;
use App\Models\Perfume;
use Illuminate\Support\Facades\DB;

class PedidoSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 500; $i++) {

            $proveedor = Proovedor::inRandomOrder()->first();

            // 🔹 crear pedido
            $pedido = Pedido::create([
                'folio' => 'PED-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'estado' => fake()->randomElement(['pendiente', 'recibido']),
                'guia' => fake()->numerify('###########'),
                'precio_envio' => fake()->numberBetween(100, 400),
                'paqueteria' => fake()->randomElement(['DHL', 'Estafeta', 'FedEx']),
                'total' => 0,
                'proovedor_id' => $proveedor->id,
                'user_id' => 1,
                'empresa_id' => 1,
            ]);

            $total = 0;

            // 🔹 seleccionar perfumes
            $perfumes = Perfume::inRandomOrder()->take(rand(1, 5))->get();

            foreach ($perfumes as $perfume) {

                $cantidad = rand(1, 5);
                $precioCompra = rand(500, 2500);

                $subtotal = $cantidad * $precioCompra;

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

            // 🔹 actualizar total
            $pedido->update([
                'total' => $total
            ]);
        }
    }
}