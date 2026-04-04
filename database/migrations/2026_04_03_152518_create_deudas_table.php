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
        Schema::create('deudas', function (Blueprint $table) {
            $table->id();

            $table->double('deuda_total');
            $table->double('abonado');
            $table->double('faltante');
            $table->string('estatus',20);

            // Relaciones existentes
            $table->foreignId('cliente_id')
                ->constrained('clientes')
                ->restrictOnDelete();

            $table->foreignId('venta_id')
                ->constrained('ventas')
                ->cascadeOnDelete();

            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();

            // Nuevo: usuario que registra la deuda
            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete(); 

            $table->timestamps();
        });
    }
 
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deudas');
    }
};
