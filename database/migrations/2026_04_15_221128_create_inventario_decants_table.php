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
        if (Schema::hasTable('inventario_decants')) {
            return;
        }

        Schema::create('inventario_decants', function (Blueprint $table) {
            $table->id();

            // Relación con el decant base (perfume líquido)
            $table->foreignId('decant_id')
                ->constrained('decants')
                ->cascadeOnDelete();

            // Relación con el tamaño/precio (aquí viene el ml)
            $table->foreignId('precio_decant_id')
                ->constrained('precios_decants')
                ->cascadeOnDelete();

            // Stock de frascos disponibles
            $table->integer('stock');

            // Usuario que registró
            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            // Empresa (multi-tenant)
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventario_decants');
    }
};
