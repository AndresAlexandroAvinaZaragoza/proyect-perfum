<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Deuda;

class AbonoSeeder extends Seeder
{
    public function run(): void
    {
        // 🔥 tomar 1000 deudas pendientes
        $deudas = Deuda::where('estatus', 'pendiente')
            ->take(1000)
            ->get();

        foreach ($deudas as $deuda) {

            // 🔹 evitar exceder la deuda
            $pago = min(200, $deuda->faltante);

            // 🔥 registrar abono
            DB::table('abono_registros')->insert([

                'pago' => $pago,

                'tipo_pago' => fake()->randomElement([
                    'efectivo',
                    'transferencia',
                    'debito'
                ]),

                'notas_adicionales' => null,

                'deuda_id' => $deuda->id,

                'user_id' => 1,

                'empresa_id' => 1,

                'created_at' => now(),

                'updated_at' => now(),
            ]);

            // 🔥 actualizar deuda
            $nuevoAbonado = $deuda->abonado + $pago;

            $nuevoFaltante = $deuda->faltante - $pago;

            DB::table('deudas')
                ->where('id', $deuda->id)
                ->update([

                    'abonado' => $nuevoAbonado,

                    'faltante' => max(0, $nuevoFaltante),

                    'estatus' => $nuevoFaltante <= 0
                        ? 'Pagada'
                        : 'pendiente',

                    'updated_at' => now(),
                ]);
        }
    }
}
