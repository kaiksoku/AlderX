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
        Schema::create('chassis', function (Blueprint $table) {

            $table->id('chass_id');

            // Datos básicos
            $table->string('chass_numero', 4)->unique();
            $table->string('chass_placa', 15)->unique();

            // Características
            $table->unsignedTinyInteger('chass_ejes');     // 2 o 3
            $table->unsignedTinyInteger('chass_medida');   // 20 o 40

            // Descripción / estructura
            $table->string('chass_estructura', 100)->nullable();

            // Estado operativo
            $table->enum('chass_estado', ['Disponible', 'Taller'])->default('Disponible');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chassis');
    }
};
