<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {

            // eliminar campo fecha
            $table->dropColumn('fecha');

            // agregar timestamps
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {

            // volver a crear fecha
            $table->dateTime('fecha');

            // eliminar timestamps
            $table->dropTimestamps();
        });
    }
};
