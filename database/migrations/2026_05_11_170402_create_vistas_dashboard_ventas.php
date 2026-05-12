<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        //  VISTA VENTAS DEL MES
        DB::statement("
            CREATE VIEW vista_ventas_mes AS
            SELECT 
                COUNT(*) AS total_ventas,
                IFNULL(SUM(total),0) AS total_ingresos
            FROM ventas
            WHERE MONTH(created_at) = MONTH(CURRENT_DATE())
            AND YEAR(created_at) = YEAR(CURRENT_DATE())
        ");

        //  VISTA VENTAS SEMANALES
        DB::statement("
            CREATE VIEW vista_ventas_semanales AS
            SELECT 
                DATE(created_at) AS fecha,
                COUNT(*) AS total_ventas,
                IFNULL(SUM(total),0) AS total_ingresos
            FROM ventas
            WHERE YEARWEEK(created_at, 1) = YEARWEEK(CURRENT_DATE(), 1)
            GROUP BY DATE(created_at)
            ORDER BY fecha ASC
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vista_ventas_mes");
        DB::statement("DROP VIEW IF EXISTS vista_ventas_semanales");
    }
};