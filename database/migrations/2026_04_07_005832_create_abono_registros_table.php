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
        if (! Schema::hasTable('abono_registros')) {
            Schema::create('abono_registros', function (Blueprint $table) {
                $table->id();

                $table->double('pago');

                $table->foreignId('deuda_id')
                    ->constrained('deudas')
                    ->cascadeOnDelete();

                $table->foreignId('user_id')
                    ->constrained('users')
                    ->restrictOnDelete();

                $table->foreignId('empresa_id')
                    ->constrained('empresas')
                    ->cascadeOnDelete();

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abono_registros');
    }
};
