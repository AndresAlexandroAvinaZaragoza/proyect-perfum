<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Marca;

class PerfumeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => fake()->words(2, true),

            'tipo' => fake()->randomElement([
                'Perfume', 'Set', 'Body', 'Loción', 'Desodorante'
            ]),

            'genero' => fake()->randomElement([
                'Caballero', 'Dama', 'Unisex'
            ]),

            'categoria' => fake()->randomElement([
                'Diseñador', 'Nicho', 'Árabe'
            ]),

            'concentracion' => fake()->randomElement([
                'EDT', 'EDP', 'Parfum', 'Elixir'
            ]),

            'contenido' => fake()->randomElement([
                50, 75, 100, 125, 200
            ]),

        
            'marca_id' => Marca::inRandomOrder()->first()->id,

            'user_id' => 1,
            'empresa_id' => 1,
        ];
    }
}
