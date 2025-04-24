<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Añadir la columna (nullable + default)
        Schema::table('pagos', function (Blueprint $table) {
            if (!Schema::hasColumn('pagos', 'anio_escolar_id')) {   // seguridad por si ya existe
                $table->unsignedBigInteger('anio_escolar_id')
                      ->nullable()      // permite nulos hasta que la llenemos
                      ->default(2)
                      ->after('abono');
            }
        });

        // 2. Poner 2 en todos los registros actuales
        DB::table('pagos')->update(['anio_escolar_id' => 2]);

        // 3. (opcional) volverla NOT NULL si quieres
        Schema::table('pagos', function (Blueprint $table) {
            $table->unsignedBigInteger('anio_escolar_id')
                  ->default(2)
                  ->nullable(false)    // la volvemos obligatoria
                  ->change();
        });

        // 4. Añadir la clave foránea
        Schema::table('pagos', function (Blueprint $table) {
            $table->foreign('anio_escolar_id')
                  ->references('id')
                  ->on('anios_escolares')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->dropForeign(['anio_escolar_id']);
            $table->dropColumn('anio_escolar_id');
        });
    }
};
