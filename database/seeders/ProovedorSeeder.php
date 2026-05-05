<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Proovedor;

class ProovedorSeeder extends Seeder
{
    public function run(): void
    {
        \Faker\Factory::create()->unique(true);

        Proovedor::factory()->count(1000)->create();
    }
}