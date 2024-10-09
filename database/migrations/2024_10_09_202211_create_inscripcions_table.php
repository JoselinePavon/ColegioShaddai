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
        Schema::create('inscripcions', function (Blueprint $table) {
            $table->id();

            // Definir las columnas de llaves foráneas
            $table->unsignedBigInteger('registro_alumnos_id');
            $table->unsignedBigInteger('grados_id');
            $table->unsignedBigInteger('seccions_id');

            // Definir las llaves foráneas
            $table->foreign('registro_alumnos_id')->references('id')->on('registro_alumnos')->onDelete('cascade');
            $table->foreign('grados_id')->references('id')->on('grados')->onDelete('cascade');
            $table->foreign('seccions_id')->references('id')->on('seccions')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripcions');
    }
};
