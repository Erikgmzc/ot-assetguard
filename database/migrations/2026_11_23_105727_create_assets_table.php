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
    Schema::create('assets', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Ej: PLC Siemens S7-1200
        $table->string('type'); // Ej: PLC, Switch, Router, Servidor
        $table->string('ip_address')->unique();
        $table->string('location'); // Ej: Planta 1 - Cuadro A
        $table->string('firmware_version')->nullable();
        $table->enum('status', ['operativo', 'mantenimiento', 'critico', 'baja'])->default('operativo');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
