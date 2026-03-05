<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('perfumes', function (Blueprint $table) {

            $table->string('tipo', 50)->change();
            $table->string('genero', 50)->change();

            $table->string('concentracion', 50)->after('genero');
        });
    }

    public function down(): void
    {
        Schema::table('perfumes', function (Blueprint $table) {

            $table->enum('tipo', ['perfume','set','body'])->change();
            $table->enum('genero', ['hombre','mujer','unisex'])->change();

            $table->dropColumn('concentracion');
        });
    }
};
