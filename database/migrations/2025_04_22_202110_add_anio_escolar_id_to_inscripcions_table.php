<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('inscripcions', function (Blueprint $table) {
            if (!Schema::hasColumn('inscripcions', 'anio_escolar_id')) {
                $table->unsignedBigInteger('anio_escolar_id')
                      ->nullable()       // debe permitir NULL
                      ->default(2)       // valor por defecto para nuevos registros
                      ->after('jornada');     // ubícala donde prefieras
            }
        });

        DB::table('inscripcions')->update(['anio_escolar_id' => 2]);

        Schema::table('inscripcions', function (Blueprint $table) {
            // Evitar doble creación si la FK ya existe:
            $fkName = 'inscripcions_anio_escolar_id_foreign';
            if (!collect(DB::select("
                    SELECT CONSTRAINT_NAME
                    FROM information_schema.KEY_COLUMN_USAGE
                    WHERE TABLE_NAME = 'inscripcions'
                      AND CONSTRAINT_NAME = '$fkName'
                "))->count()) {

                $table->foreign('anio_escolar_id', $fkName)
                      ->references('id')
                      ->on('anios_escolares')
                      ->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('inscripcions', function (Blueprint $table) {
            $table->dropForeign(['anio_escolar_id']);
            $table->dropColumn('anio_escolar_id');
        });
    }
};
