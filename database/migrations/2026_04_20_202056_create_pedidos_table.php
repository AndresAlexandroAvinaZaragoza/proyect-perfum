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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',50);
            $table->string('guia',50)->nullable();
            $table->string('paqueteria',20)->nullable();
            $table->dateTime('fecha');

            $table->foreignId('proovedor_id')
                ->constrained('proovedores');

            $table->foreignId('user_id')
                ->constrained('users');

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
        Schema::dropIfExists('pedidos');
    }
};
