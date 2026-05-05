<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Cliente;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        \Faker\Factory::create()->unique(true);

        Cliente::factory()->count(1000)->create();
    }
}