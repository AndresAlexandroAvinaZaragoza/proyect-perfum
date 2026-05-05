<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => fake()->name(),
            'celular' => fake()->numerify('33########'), // formato tipo México
            'user_id' => 1, // ya tienes usuario 1
            'empresa_id' => 1,
        ];
    }
}