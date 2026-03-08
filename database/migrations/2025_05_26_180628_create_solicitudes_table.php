<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudesTable extends Migration
{
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id('soli_id');

            $table->text('soli_justificación')->nullable();
            $table->string('soli_tiempo'); // Ej: Desayuno, Almuerzo, Cena
            $table->unsignedBigInteger('soli_restaurante');
            $table->unsignedBigInteger('soli_usuario'); // Creador de la solicitud

            $table->dateTime('soli_generacion'); // Cuándo se genera
            $table->dateTime('soli_aceptacion')->nullable(); // Cuándo se acepta
            $table->dateTime('soli_facturacion')->nullable(); // Cuándo se factura

            $table->integer('soli_semana'); // Semana del año
            $table->integer('soli_anio');   // Año
            $table->string('soli_boleta', 20)->unique(); // Ej: 22-2025-000001

            $table->string('soli_estado'); // generado, aceptado, facturado, etc.

            $table->unsignedBigInteger('soli_departamento'); // del usuario logueado

            $table->timestamps();

            // Llaves foráneas
            $table->foreign('soli_restaurante')->references('rest_id')->on('restaurantes')->onDelete('cascade');
            $table->foreign('soli_usuario')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('soli_departamento')->references('dep_id')->on('departamentos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitudes');
    }
}
