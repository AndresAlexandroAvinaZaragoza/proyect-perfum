<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER descontar_liquido_decant
            AFTER INSERT ON inventario_decants
            FOR EACH ROW
            BEGIN
                DECLARE ml_val INT;

                SELECT ml INTO ml_val
                FROM precios_decants
                WHERE id = NEW.precio_decant_id;

                UPDATE decants
                SET cantidad_restante = cantidad_restante - (ml_val * NEW.stock)
                WHERE id = NEW.decant_id;
            END
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS descontar_liquido_decant');
    }
};
