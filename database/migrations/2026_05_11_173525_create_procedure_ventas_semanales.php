<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared("
            DROP PROCEDURE IF EXISTS reporte_ventas_semanales;

            CREATE PROCEDURE reporte_ventas_semanales(
                IN fecha_inicio DATE,
                IN fecha_fin DATE
            )
            BEGIN

                SELECT 
                    DATE(created_at) AS fecha,

                    COUNT(*) AS total_ventas,

                    IFNULL(SUM(total),0) AS total_ingresos

                FROM ventas

                WHERE created_at BETWEEN fecha_inicio AND fecha_fin

                GROUP BY DATE(created_at)

                ORDER BY fecha ASC;

            END
        ");
    }

    public function down(): void
    {
        DB::unprepared("
            DROP PROCEDURE IF EXISTS reporte_ventas_semanales
        ");
    }
};