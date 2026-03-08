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
        Schema::create('detalle_solicitud', function (Blueprint $table) {
        $table->id('det_id');
        $table->unsignedBigInteger('det_solicitud');
        $table->unsignedBigInteger('det_empleado');
        $table->timestamps();
        $table->foreign('det_solicitud')->references('soli_id')->on('solicitudes')->onDelete('cascade');
        $table->foreign('det_empleado')->references('id')->on('users')->onDelete('cascade');
        $table->unique(['det_solicitud', 'det_empleado']); // Para evitar duplicados
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_solicitud');
    }
};
