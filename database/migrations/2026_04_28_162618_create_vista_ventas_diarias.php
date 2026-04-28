<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            CREATE VIEW vista_ventas_diarias AS
            SELECT 
                DATE(created_at) AS fecha,
                SUM(pago) AS total
            FROM abono_registros
            GROUP BY DATE(created_at)
            ORDER BY fecha ASC
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vista_ventas_diarias");
    }
};
