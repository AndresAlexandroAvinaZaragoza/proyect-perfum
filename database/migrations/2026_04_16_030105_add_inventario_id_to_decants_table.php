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
        Schema::table('decants', function (Blueprint $table) {

            $table->foreignId('inventario_id')
                ->after('precio_botella')
                ->constrained('inventarios')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('decants', function (Blueprint $table) {

            $table->dropForeign(['inventario_id']);
            $table->dropColumn('inventario_id');
        });
    }
};
