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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->decimal('adelanto_mantenimiento')->default(0.00);
            $table->decimal('total_mantenimiento')->default(0.00)->nullable();
            $table->decimal('saldo_restante')->nullable()->virtualAs('COALESCE(total_mantenimiento, 0) - COALESCE(adelanto_mantenimiento, 0)');
            $table->foreignId('id_entidad')->constrained('entities')->onDelete('cascade');
            $table->foreignId('id_recoge')->onDelete('set null')->constrained('entities')->nullable();
            $table->string('estado_mantenimiento', 100)->default('Pendiente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
