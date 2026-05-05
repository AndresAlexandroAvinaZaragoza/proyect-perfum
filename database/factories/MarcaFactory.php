<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MarcaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => fake()->unique()->company(),
            'pais_origen' => substr(fake()->country(), 0, 20),
            'registro_fecha' => now(),
            'empresa_id' => 1, // ya tienes empresa 1
            'usuario_id' => 1, // usuario admin
        ];
    }
}