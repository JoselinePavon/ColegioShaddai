<?php

use App\Models\Grado;
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
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('genero');
            $table->Integer('edad');
            $table->date('fecha_nacimiento');
            $table->unsignedBigInteger('grados_id');
            $table->foreign('grados_id')->references('id')->on('grados');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */

        public function grado()
    {
        return $this->belongsTo(Grado::class, 'grados_id');
    }

};

