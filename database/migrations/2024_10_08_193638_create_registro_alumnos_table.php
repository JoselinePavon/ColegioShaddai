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
        Schema::create('registro_alumnos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_personal');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('genero');
            $table->string('parentesco');
            $table->Integer('edad');
            $table->date('fecha_nacimiento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_alumnos');
    }
};
