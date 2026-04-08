<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('abono_registros', function (Blueprint $table) {
            if (! Schema::hasColumn('abono_registros', 'tipo_pago')) {
                $table->string('tipo_pago', 20)->after('pago');
            }

            if (! Schema::hasColumn('abono_registros', 'notas_adicionales')) {
                $table->text('notas_adicionales')->nullable()->after('tipo_pago');
            }

        });
    }

    public function down(): void
    {
        Schema::table('abono_registros', function (Blueprint $table) {
            $columnsToDrop = [];

            if (Schema::hasColumn('abono_registros', 'tipo_pago')) {
                $columnsToDrop[] = 'tipo_pago';
            }

            if (Schema::hasColumn('abono_registros', 'notas_adicionales')) {
                $columnsToDrop[] = 'notas_adicionales';
            }

            if (! empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }

        });
    }
};