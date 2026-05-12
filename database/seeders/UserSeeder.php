<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [];

        // 🔥 hash solo una vez
        $password = Hash::make('12345678');

        for ($i = 1; $i <= 1000; $i++) {

            $usuarios[] = [

                'name' => fake()->name(),

                'usuario' => 'user' . $i,

                'email' => 'usuario' . $i . '@gmail.com',

                'password' => $password,

                'rol' => fake()->randomElement([
                    'admin',
                    'empleado'
                ]),

                'empresa_id' => 1,

                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('users')->insert($usuarios);
    }
}

