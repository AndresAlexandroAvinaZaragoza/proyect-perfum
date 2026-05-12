<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Trigger para descontar cuando se ACTUALIZA el stock (se suma al inventario existente)
        DB::unprepared("
            CREATE TRIGGER descontar_liquido_decant_update
            AFTER UPDATE ON inventario_decants
            FOR EACH ROW
            BEGIN
                DECLARE ml_val INT;
                DECLARE cantidad_actual DECIMAL(10,2);
                DECLARE total_descuento DECIMAL(10,2);
                DECLARE delta INT;

                -- calcular diferencia de stock (delta)
                SET delta = NEW.stock - OLD.stock;

                IF delta > 0 THEN

                    -- obtener ml del tamaño
                    SELECT ml INTO ml_val
                    FROM precios_decants
                    WHERE id = NEW.precio_decant_id;

                IF ml_val IS NULL OR ml_val <= 0 THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'ML inválido en precios_decants';
                END IF;

                -- obtener cantidad actual del decant
                SELECT cantidad_restante INTO cantidad_actual
                FROM decants
                WHERE id = NEW.decant_id;

                IF cantidad_actual IS NULL THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Decant no encontrado';
                END IF;

                SET total_descuento = ml_val * delta;

                IF cantidad_actual < total_descuento THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'No hay suficiente líquido para generar inventario (update)';
                END IF;

                    UPDATE decants
                    SET cantidad_restante = cantidad_actual - total_descuento
                    WHERE id = NEW.decant_id;

                END IF;
            END;
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS descontar_liquido_decant_update");
    }
};
