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

            $table->string('codigo_correlativo');
            $table->unsignedBigInteger('registro_alumnos_id');
            $table->unsignedBigInteger('grados_id');
            $table->unsignedBigInteger('seccions_id');
            $table->string('jornada');



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
