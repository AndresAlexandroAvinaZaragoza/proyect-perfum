<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            CREATE VIEW vista_transacciones AS
            SELECT 
                ar.id,
                u.name AS usuario,
                ar.created_at,
                ar.pago,
                'COMPLETED' AS estado
            FROM abono_registros ar
            JOIN users u ON ar.user_id = u.id
            ORDER BY ar.created_at DESC
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vista_transacciones");
    }
};
