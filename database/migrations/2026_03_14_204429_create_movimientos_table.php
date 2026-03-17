<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('movimientos', function (Blueprint $table) {
        $table->id('mov_id');

        // Relaciones
        $table->unsignedBigInteger('mov_recinto'); // FK a recintos
        $table->unsignedBigInteger('mov_condicionista'); // FK a users
        $table->unsignedBigInteger('mov_digitador'); // FK a users

        // Datos principales
        $table->string('mov_boleta')->unique();
        $table->date('mov_fecha');
        $table->time('mov_hora');
        $table->string('mov_cabezal');
        $table->string('mov_placacabezal');

        // Contenedor
        $table->string('mov_contenedor')->nullable();
        $table->string('mov_pvcontenedor')->nullable();
        $table->date('mov_contenedorfecha')->nullable();
        $table->string('mov_naviera');
        $table->string('mov_setpoint');
        $table->string('mov_damper');
        $table->string('mov_sellocontenedor');

        // Información general
        $table->string('mov_contenido');
        $table->string('mov_cliente');
        $table->string('mov_conductor');

        // Chassis
        $table->string('mov_chassis');
        $table->string('mov_placachassis');
        $table->string('mov_pvchassis');
        $table->date('mov_chassisfecha');
        $table->bigInteger('mov_hubodometro');

        // Tipo de movimiento
        $table->string('mov_tipomovimiento');

        // Genset 1
        $table->string('mov_genset_1')->nullable();
        $table->string('mov_pvgenset_1')->nullable();
        $table->date('mov_gensetfecha_1')->nullable();
        $table->decimal('mov_horometro_ingreso_1', 9, 1)->nullable();
        $table->decimal('mov_horometro_salida_1', 9, 1)->nullable();
        $table->decimal('mov_gal_salida_1', 2, 1)->nullable();
        $table->decimal('mov_gal_diferencia_1', 2, 1)->nullable();
        $table->decimal('mov_gal_ingreso_1', 2, 1)->nullable();
        $table->string('mov_marchamotanque_1')->nullable();
        $table->string('mov_marchamopuerta_1')->nullable();
        $table->string('mov_marchamopanel1_1')->nullable();
        $table->string('mov_marchamopanel2_1')->nullable();
        // Genset 2
        $table->string('mov_genset_2')->nullable();
        $table->string('mov_pvgenset_2')->nullable();
        $table->date('mov_gensetfecha_2')->nullable();
        $table->decimal('mov_horometro_ingreso_2', 9, 1)->nullable();
        $table->decimal('mov_horometro_salida_2', 9, 1)->nullable();
        $table->decimal('mov_gal_salida_2', 2, 1)->nullable();
        $table->decimal('mov_gal_diferencia_2', 2, 1)->nullable();
        $table->decimal('mov_gal_ingreso_2', 2, 1)->nullable();
        $table->string('mov_marchamotanque_2')->nullable();
        $table->string('mov_marchamopuerta_2')->nullable();
        $table->string('mov_marchamopanel1_2')->nullable();
        $table->string('mov_marchamopanel2_2')->nullable();

        // Observaciones
        $table->text('mov_observaciones')->nullable();

        // Llantas 1–12
        for ($i = 1; $i <= 12; $i++) {

    $col1 = $table->string("mov_llanta{$i}_quemado");
    $col2 = $table->string("mov_llanta{$i}_profundidad");
    $col3 = $table->string("mov_llanta{$i}_marca");

    if ($i >= 9) {
        $col1->nullable();
        $col2->nullable();
        $col3->nullable();
    }
}

        $table->timestamps();

        // Foreign keys
        $table->foreign('mov_recinto')->references('reci_id')->on('recintos');
        $table->foreign('mov_condicionista')->references('id')->on('users');
        $table->foreign('mov_digitador')->references('id')->on('users');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
