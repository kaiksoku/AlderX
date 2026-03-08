<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurantes', function (Blueprint $table) {
            $table->id('rest_id'); // ID auto incremental
            $table->string('rest_nombre', 255)->unique(); // Nombre del restaurante
            $table->string('rest_correo', 255)->unique(); // Correo del restaurante
            $table->string('rest_horarios', 255); // Horarios en que atiende
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurantes');
    }
}
