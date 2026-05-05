<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProovedorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => fake()->company(),

            // teléfono tipo México
            'celular' => fake()->numerify('33########'),

            // correo coherente con empresa
            'correo' => fake()->unique()->companyEmail(),

            'user_id' => 1,
            'empresa_id' => 1,
        ];
    }
}