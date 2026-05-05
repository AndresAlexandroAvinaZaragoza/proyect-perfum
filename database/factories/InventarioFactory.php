<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Perfume;

class InventarioFactory extends Factory
{
    public function definition(): array
    {
        $precioCompra = fake()->numberBetween(500, 5000);

        return [
            'precio_compra' => $precioCompra,

            'precio_venta' => $precioCompra + fake()->numberBetween(300, 1500),

            'stock' => fake()->numberBetween(0, 100),

            
            'perfume_id' => Perfume::inRandomOrder()->first()->id,

            'user_id' => 1,
            'empresa_id' => 1,
        ];
    }
}
