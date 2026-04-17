<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('decants', function (Blueprint $table) {
            $table->decimal('precio_botella', 10, 2)->after('precio_por_ml');
        });
    }

    public function down(): void
    {
        Schema::table('decants', function (Blueprint $table) {
            $table->dropColumn('precio_botella');
        });
    }
};