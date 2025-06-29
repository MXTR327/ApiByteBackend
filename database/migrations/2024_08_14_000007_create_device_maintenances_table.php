<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('device_maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_equipo')->constrained('devices');
            $table->foreignId('id_mantenimiento')->constrained('maintenances');
            $table->string('serie')->nullable();
            $table->decimal('precio_mantenimiento_equipo')->nullable();
            $table->text('motivo_mantenimiento')->nullable();
            $table->text('condiciones_fisicas')->nullable();
            $table->string('detalles_equipo_extra', 255)->nullable();
            $table->string('diagnostico_equipo', 255)->nullable();
            $table->string('estado_actual', 100)->default('Pendiente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_maintenances');
    }
};
