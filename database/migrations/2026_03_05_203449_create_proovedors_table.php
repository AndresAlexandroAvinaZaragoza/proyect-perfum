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
        Schema::create('proovedores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('celular', 15);
            $table->string('correo', 100);
            
            $table->foreignId('user_id')
            ->constrained('users')
            ->restrictOnDelete();

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
        Schema::dropIfExists('proovedores');
    }
};
