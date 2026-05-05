<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. PRECIO POR ML (INSERT)
        DB::unprepared("
            CREATE TRIGGER actualizar_precio_por_ml_insert
            BEFORE INSERT ON decants
            FOR EACH ROW
            BEGIN
                DECLARE contenido_val DECIMAL(10,2);

                SELECT contenido INTO contenido_val
                FROM perfumes
                WHERE id = NEW.perfume_id;

                IF contenido_val IS NULL OR contenido_val <= 0 THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Contenido inválido del perfume';
                END IF;

                SET NEW.precio_por_ml = NEW.precio_botella / contenido_val;
            END;
        ");

        // 3. DESCONTAR LÍQUIDO (CORREGIDO)
        DB::unprepared("
            CREATE TRIGGER descontar_liquido_decant
            AFTER INSERT ON inventario_decants
            FOR EACH ROW
            BEGIN
                DECLARE ml_val INT;
                DECLARE cantidad_actual DECIMAL(10,2);
                DECLARE total_descuento DECIMAL(10,2);

                -- obtener ml del tamaño
                SELECT ml INTO ml_val
                FROM precios_decants
                WHERE id = NEW.precio_decant_id;

                IF ml_val IS NULL OR ml_val <= 0 THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'ML inválido en precios_decants';
                END IF;

                -- obtener cantidad actual
                SELECT cantidad_restante INTO cantidad_actual
                FROM decants
                WHERE id = NEW.decant_id;

                IF cantidad_actual IS NULL THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Decant no encontrado';
                END IF;

                SET total_descuento = ml_val * NEW.stock;

                IF cantidad_actual < total_descuento THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'No hay suficiente líquido para generar inventario';
                END IF;

                UPDATE decants
                SET cantidad_restante = cantidad_actual - total_descuento
                WHERE id = NEW.decant_id;
            END;
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS actualizar_precio_por_ml_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS descontar_liquido_decant");
    }
};