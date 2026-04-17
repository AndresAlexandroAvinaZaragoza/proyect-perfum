<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('inventario_decants', function (Blueprint $table) {


            $table->foreign('precio_decant_id')
                ->references('id')->on('precios_decants')
                ->cascadeOnDelete();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->restrictOnDelete();

            $table->foreign('empresa_id')
                ->references('id')->on('empresas')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventario_decants', function (Blueprint $table) {
            //
        });
    }
};
