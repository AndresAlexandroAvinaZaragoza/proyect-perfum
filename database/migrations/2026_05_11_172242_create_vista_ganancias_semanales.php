<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            CREATE VIEW vista_ganancias_semanales AS

            SELECT 
                fechas.fecha,

                -- INGRESOS TOTALES
                IFNULL(p.ingresos_perfumes,0)
                +
                IFNULL(d.ingresos_decants,0)
                AS ingresos_totales,

                -- COSTOS TOTALES
                IFNULL(p.costos_perfumes,0)
                +
                IFNULL(d.costos_decants,0)
                AS costos_totales,

                -- GANANCIA REAL
                (
                    IFNULL(p.ingresos_perfumes,0)
                    +
                    IFNULL(d.ingresos_decants,0)
                )
                -
                (
                    IFNULL(p.costos_perfumes,0)
                    +
                    IFNULL(d.costos_decants,0)
                )
                AS ganancia_real

            FROM

            (
                -- FECHAS DE LA SEMANA
                SELECT DISTINCT DATE(created_at) AS fecha
                FROM ventas
                WHERE YEARWEEK(created_at,1) = YEARWEEK(CURRENT_DATE(),1)
            ) fechas

            LEFT JOIN
            (
                -- PERFUMES
                SELECT 
                    DATE(v.created_at) AS fecha,

                    SUM(dv.subtotal) AS ingresos_perfumes,

                    SUM(i.precio_compra * dv.cantidad)
                    AS costos_perfumes

                FROM detalle__ventas dv

                JOIN ventas v
                    ON dv.venta_id = v.id

                JOIN inventarios i
                    ON dv.perfume_id = i.perfume_id

                WHERE YEARWEEK(v.created_at,1) =
                    YEARWEEK(CURRENT_DATE(),1)

                GROUP BY DATE(v.created_at)

            ) p

            ON fechas.fecha = p.fecha

            LEFT JOIN
            (
                -- DECANTS
                SELECT 
                    DATE(v.created_at) AS fecha,

                    SUM(dvd.subtotal)
                    AS ingresos_decants,

                    SUM(d.precio_por_ml * dvd.ml * dvd.cantidad)
                    AS costos_decants

                FROM detalle_venta_decants dvd

                JOIN ventas v
                    ON dvd.venta_id = v.id

                JOIN decants d
                    ON dvd.decant_id = d.id

                WHERE YEARWEEK(v.created_at,1) =
                    YEARWEEK(CURRENT_DATE(),1)

                GROUP BY DATE(v.created_at)

            ) d

            ON fechas.fecha = d.fecha

            ORDER BY fechas.fecha ASC
        ");
    }

    public function down(): void
    {
        DB::statement("
            DROP VIEW IF EXISTS vista_ganancias_semanales
        ");
    }
};