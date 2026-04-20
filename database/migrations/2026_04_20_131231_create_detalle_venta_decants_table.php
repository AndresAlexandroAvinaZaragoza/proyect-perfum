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
        Schema::create('detalle_venta_decants', function (Blueprint $table) {
            $table->id();

            $table->integer('ml');
            $table->integer('cantidad');
            $table->float('precio_unitario', 10, 2);
            $table->float('subtotal', 10, 2);

            $table->foreignId('venta_id')
                ->constrained('ventas')
                ->cascadeOnDelete();

            $table->foreignId('decant_id')
                ->constrained('decants')
                ->restrictOnDelete();

            $table->foreignId('inventario_decant_id')
                ->constrained('inventario_decants')
                ->cascadeOnDelete();

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
        Schema::dropIfExists('detalle_venta_decants');
    }
};
