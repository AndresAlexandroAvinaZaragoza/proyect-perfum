<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            CREATE VIEW vista_ganancias_reales_mes AS

            SELECT 

                -- TOTAL VENTAS
                (
                    SELECT COUNT(*)
                    FROM ventas v
                    WHERE MONTH(v.created_at) = MONTH(CURRENT_DATE())
                    AND YEAR(v.created_at) = YEAR(CURRENT_DATE())
                ) AS total_ventas,

                -- INGRESOS PERFUMES
                (
                    SELECT IFNULL(SUM(dv.subtotal),0)
                    FROM detalle__ventas dv
                    JOIN ventas v ON dv.venta_id = v.id
                    WHERE MONTH(v.created_at) = MONTH(CURRENT_DATE())
                    AND YEAR(v.created_at) = YEAR(CURRENT_DATE())
                )

                +

                -- INGRESOS DECANTS
                (
                    SELECT IFNULL(SUM(dvd.subtotal),0)
                    FROM detalle_venta_decants dvd
                    JOIN ventas v ON dvd.venta_id = v.id
                    WHERE MONTH(v.created_at) = MONTH(CURRENT_DATE())
                    AND YEAR(v.created_at) = YEAR(CURRENT_DATE())
                )

                AS ingresos_totales,

                -- COSTOS PERFUMES
                (
                    SELECT IFNULL(SUM(i.precio_compra * dv.cantidad),0)
                    FROM detalle__ventas dv
                    JOIN ventas v ON dv.venta_id = v.id
                    JOIN inventarios i ON dv.perfume_id = i.perfume_id
                    WHERE MONTH(v.created_at) = MONTH(CURRENT_DATE())
                    AND YEAR(v.created_at) = YEAR(CURRENT_DATE())
                )

                +

                -- COSTOS DECANTS
                (
                    SELECT IFNULL(SUM(d.precio_por_ml * dvd.ml * dvd.cantidad),0)
                    FROM detalle_venta_decants dvd
                    JOIN ventas v ON dvd.venta_id = v.id
                    JOIN decants d ON dvd.decant_id = d.id
                    WHERE MONTH(v.created_at) = MONTH(CURRENT_DATE())
                    AND YEAR(v.created_at) = YEAR(CURRENT_DATE())
                )

                AS costo_total
        ");

        DB::statement("
            CREATE OR REPLACE VIEW vista_ganancias_final AS

            SELECT 
                total_ventas,
                ingresos_totales,
                costo_total,

                (ingresos_totales - costo_total)
                AS ganancia_real

            FROM vista_ganancias_reales_mes
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vista_ganancias_final");
        DB::statement("DROP VIEW IF EXISTS vista_ganancias_reales_mes");
    }
};