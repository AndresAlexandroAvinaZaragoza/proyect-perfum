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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_usuario', 100);
            $table->string('usuario', 50)->unique();
            $table->string('correo_electronico', 100);
            $table->string('password', 255);
            $table->string('rol', 20);
            $table->dateTime('registro_fecha');

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
        Schema::dropIfExists('usuarios');
    }
};
