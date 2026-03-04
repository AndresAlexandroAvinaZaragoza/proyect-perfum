<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->string('usuario', 50)->unique()->after('name');
            $table->string('rol', 20)->after('password');
            $table->foreignId('empresa_id')
                ->nullable()
                ->constrained('empresas')
                ->cascadeOnDelete()
                ->after('rol');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['empresa_id']);
            $table->dropColumn(['usuario', 'rol', 'empresa_id']);
        });
    }
};

