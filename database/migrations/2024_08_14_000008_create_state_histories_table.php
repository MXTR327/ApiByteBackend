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
        Schema::create('state_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_equipo_mantenimiento')->constrained('device_maintenances')->onDelete('cascade');
            $table->string('estado', 100);
            $table->string('notas_historial', 255);
            $table->string('anexo', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('state_histories');
    }
};
