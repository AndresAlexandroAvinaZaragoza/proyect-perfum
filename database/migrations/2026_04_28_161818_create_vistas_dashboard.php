<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            CREATE VIEW vista_dashboard_admin AS
            SELECT 
                COUNT(ar.id) AS total_abonos,
                SUM(ar.pago) AS total_ingresos
            FROM abono_registros ar
        ");

        DB::statement("
            CREATE VIEW vista_dashboard_usuario AS
            SELECT 
                COUNT(ar.id) AS total_abonos
            FROM abono_registros ar
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vista_dashboard_admin");
        DB::statement("DROP VIEW IF EXISTS vista_dashboard_usuario");
    }
};