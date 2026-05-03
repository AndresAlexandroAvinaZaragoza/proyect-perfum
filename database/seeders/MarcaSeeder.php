<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Marca;

class MarcaSeeder extends Seeder
{
    public function run(): void
    {
        // reset unique faker (evita errores si corres varias veces)
        \Faker\Factory::create()->unique(true);

        Marca::factory()->count(1000)->create();
    }
}