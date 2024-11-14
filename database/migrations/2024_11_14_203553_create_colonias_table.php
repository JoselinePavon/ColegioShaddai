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
        Schema::create('colonias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->foreignId('lugars_id')->constrained('lugars')->onDelete('cascade'); // Llave foránea para relacionar con 'lugares'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colonias');
    }
};
