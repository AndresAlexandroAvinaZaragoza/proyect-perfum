<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared("
            DROP PROCEDURE IF EXISTS reporte_ventas_por_usuario;

            CREATE PROCEDURE reporte_ventas_por_usuario(
                IN usuario_id INT
            )
            BEGIN
                SELECT 
                    u.name AS usuario,
                    COUNT(ar.id) AS total_ventas,
                    IFNULL(SUM(ar.total),0) AS total_ingresos
                FROM ventas ar
                JOIN users u ON ar.user_id = u.id
                WHERE ar.user_id = usuario_id
                GROUP BY u.name;
            END
        ");
            }

    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS reporte_ventas_por_usuario");
    }
};
