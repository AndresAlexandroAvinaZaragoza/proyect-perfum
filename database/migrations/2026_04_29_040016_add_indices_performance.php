<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        //  RELACIONES CLAVE 
        DB::statement("CREATE INDEX idx_perfumes_marca_id ON perfumes(marca_id)");
        DB::statement("CREATE INDEX idx_perfumes_user_id ON perfumes(user_id)");

        //  FILTROS DEL BUSCADOR
        DB::statement("CREATE INDEX idx_perfumes_genero ON perfumes(genero)");
        DB::statement("CREATE INDEX idx_perfumes_tipo ON perfumes(tipo)");

        //  
        DB::statement("CREATE INDEX idx_perfumes_categoria ON perfumes(categoria)");
        DB::statement("CREATE INDEX idx_perfumes_concentracion ON perfumes(concentracion)");

        //  BÚSQUEDA POR NOMBRE 
        DB::statement("CREATE INDEX idx_perfumes_nombre ON perfumes(nombre)");
    }

    public function down(): void
    {
        DB::statement("DROP INDEX idx_perfumes_marca_id ON perfumes");
        DB::statement("DROP INDEX idx_perfumes_user_id ON perfumes");

        DB::statement("DROP INDEX idx_perfumes_genero ON perfumes");
        DB::statement("DROP INDEX idx_perfumes_tipo ON perfumes");

        DB::statement("DROP INDEX idx_perfumes_categoria ON perfumes");
        DB::statement("DROP INDEX idx_perfumes_concentracion ON perfumes");

        DB::statement("DROP INDEX idx_perfumes_nombre ON perfumes");
    }
};