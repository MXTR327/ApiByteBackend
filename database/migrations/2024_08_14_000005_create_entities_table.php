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
        Schema::create('entities', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_entidad', 255);
            $table->string('tipo_entidad', 50);
            $table->string('identificacion_entidad', 11)->unique();
            $table->string('telefono_entidad', 15);
            $table->text('direccion_entidad');
            $table->string('referencia_direccion_entidad', 255)->nullable()->default('SIN ESPECIFICAR');
            $table->string('tipo_identificacion_entidad', 100);
            $table->foreignId('id_entidad_padre')->nullable()->constrained('entities')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entities');
    }
};
