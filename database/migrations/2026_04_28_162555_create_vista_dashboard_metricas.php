<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            CREATE VIEW vista_dashboard_metricas AS
            SELECT 
                (SELECT IFNULL(SUM(pago),0) 
                 FROM abono_registros 
                 WHERE MONTH(created_at) = MONTH(CURRENT_DATE())
                 AND YEAR(created_at) = YEAR(CURRENT_DATE())
                ) AS total_ventas_mes,

                (SELECT COUNT(*) FROM clientes) AS clientes_activos,

                (SELECT IFNULL(SUM(faltante),0) FROM deudas) AS deudas_pendientes,

                (SELECT COUNT(*) 
                 FROM inventarios i
                 WHERE i.stock < 5
                ) AS stock_critico
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vista_dashboard_metricas");
    }
};