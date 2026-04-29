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
                IN fecha_inicio DATE,
                IN fecha_fin DATE
            )
            BEGIN
                SELECT 
                    u.name AS usuario,
                    COUNT(ar.id) AS total_ventas,
                    IFNULL(SUM(ar.pago),0) AS total_ingresos
                FROM abono_registros ar
                JOIN users u ON ar.user_id = u.id
                WHERE ar.created_at BETWEEN fecha_inicio AND fecha_fin
                GROUP BY u.name
                ORDER BY total_ingresos DESC;
            END
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS reporte_ventas_por_usuario");
    }
};