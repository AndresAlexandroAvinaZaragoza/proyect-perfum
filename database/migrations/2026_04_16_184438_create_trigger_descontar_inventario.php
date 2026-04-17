<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Evita error si ya existe
        DB::unprepared('DROP TRIGGER IF EXISTS descontar_inventario_por_decant');

        DB::unprepared('
            CREATE TRIGGER descontar_inventario_por_decant
            BEFORE INSERT ON decants
            FOR EACH ROW
            BEGIN
                DECLARE stock_actual INT;

                SELECT stock INTO stock_actual
                FROM inventarios
                WHERE id = NEW.inventario_id;

                IF stock_actual <= 0 THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "No hay botellas disponibles en inventario";
                END IF;

                UPDATE inventarios
                SET stock = stock - 1
                WHERE id = NEW.inventario_id;
            END
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS descontar_inventario_por_decant');
    }
};
