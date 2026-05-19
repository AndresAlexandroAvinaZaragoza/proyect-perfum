<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpresaSeeder extends Seeder
{
    public function run(): void
    {
        $empresas = [];

        for ($i = 1; $i <= 1000; $i++) {

            $empresas[] = [

                'nombre_empresa' => fake()->company(),

                'plan' => fake()->randomElement([
                    'BASIC',
                    'PREMIUM',
                    'EMPRESARIAL'
                ]),

                'registro_fecha' => fake()->dateTimeBetween(
                    '-2 years',
                    'now'
                ),

                'estatus' => fake()->randomElement([
                    'Activo',
                    'Suspendido',
                    'Inactivo'
                ]),

                'created_at' => now(),

                'updated_at' => now(),
            ];
        }

        DB::table('empresas')->insert($empresas);
    }
}