<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared("
            CREATE TRIGGER actualizar_precio_por_ml_insert
            BEFORE INSERT ON decants
            FOR EACH ROW
            BEGIN
                IF NEW.cantidad_restante = 0 THEN
                    SET NEW.precio_por_ml = 0;
                ELSE
                    SET NEW.precio_por_ml = NEW.precio_botella / NEW.cantidad_restante;
                END IF;
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER actualizar_precio_por_ml_update
            BEFORE UPDATE ON decants
            FOR EACH ROW
            BEGIN
                IF NEW.cantidad_restante = 0 THEN
                    SET NEW.precio_por_ml = 0;
                ELSE
                    SET NEW.precio_por_ml = NEW.precio_botella / NEW.cantidad_restante;
                END IF;
            END;
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS actualizar_precio_por_ml_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS actualizar_precio_por_ml_update");
    }
};
