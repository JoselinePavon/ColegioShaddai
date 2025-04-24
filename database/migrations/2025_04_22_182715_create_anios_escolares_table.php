<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('anios_escolares', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 20);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->timestamps(); // Opcional: si no lo necesitas, puedes quitarlo
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anios_escolares');
    }
};

