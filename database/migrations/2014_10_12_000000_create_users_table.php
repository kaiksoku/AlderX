<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.s
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();

            $table->unsignedBigInteger('departamento'); // campo para la clave foránea
            // Definir la clave foránea de manera explícita
            $table->foreign('departamento', 'fk_departamentos_usuario')
                  ->references('dep_id')->on('departamentos')
                  ->onDelete('cascade'); // Elimina productos si se elimina la categoría

            $table->unsignedBigInteger('recinto'); // campo para la clave foránea
            $table->foreign('recinto', 'fk_recintos_usuario')
            ->references('reci_id')->on('recintos')
            ->onDelete('cascade'); // Elimina productos si se elimina la categoría


            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
