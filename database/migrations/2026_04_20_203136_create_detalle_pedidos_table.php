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
        Schema::create('detalle_pedidos', function (Blueprint $table) {
            $table->id();
            $table->decimal('cantidad',10,2);
            $table->decimal('precio_de_compra',12,2);

            $table->foreignId('pedido_id')
                ->constrained('pedidos')
                ->cascadeOnDelete();

            $table->foreignId('perfume_id')
                ->constrained('perfumes');

            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_pedidos');
    }
};
