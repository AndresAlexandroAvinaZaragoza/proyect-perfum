<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {

            // eliminar nombre
            $table->dropColumn('nombre');

            //  agregar folio
            $table->string('folio')->unique()->after('id');

            //  agregar estado
            $table->enum('estado', ['pendiente', 'recibido'])
                ->default('pendiente')
                ->after('folio');
        });
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {

            //  eliminar nuevos campos
            $table->dropColumn(['folio', 'estado']);

            //  regresar nombre
            $table->string('nombre', 50)->after('id');
        });
    }
};