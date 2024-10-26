<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagosTable extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->string('num_serie');
            $table->string('fecha_pago'); // Cambié a 'date' para un mejor manejo de fechas
            $table->unsignedBigInteger('tipopagos_id'); // Agregando la columna tipopagos_id
            $table->unsignedBigInteger('registro_alumnos_id'); // Agregando la columna registro_alumnos_id
            $table->timestamps();

            // Agregando las claves foráneas
            $table->foreign('tipopagos_id')->references('id')->on('tipopagos')->onDelete('cascade');
            $table->foreign('registro_alumnos_id')->references('id')->on('registro_alumnos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->dropForeign(['tipopagos_id']);
            $table->dropForeign(['registro_alumnos_id']);
        });

        Schema::dropIfExists('pagos');
    }
}
