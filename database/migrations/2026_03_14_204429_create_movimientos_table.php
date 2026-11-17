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
        $table->string('mov_boleta', 50)->unique();
        $table->date('mov_fecha');
        $table->time('mov_hora');
        $table->string('mov_cabezal', 100);
        $table->string('mov_placacabezal', 50);
        $table->bigInteger('mov_kilometraje')->nullable();

        // Contenedor
        $table->string('mov_contenedor', 50)->nullable();
        $table->string('mov_pvcontenedor', 50)->nullable();
        $table->date('mov_contenedorfecha')->nullable();
        $table->string('mov_naviera', 100);
        $table->string('mov_setpoint', 50);
        $table->string('mov_damper', 50);
        $table->string('mov_sellocontenedor', 50);

        // Información general
        $table->string('mov_contenido', 100);
        $table->string('mov_cliente', 100);
        $table->string('mov_conductor', 100);

        // Chassis
        $table->string('mov_chassis', 50);
        $table->string('mov_placachassis', 50);
        $table->string('mov_pvchassis', 50);
        $table->date('mov_chassisfecha');
        $table->bigInteger('mov_hubodometro');

        // Tipo de movimiento
        $table->string('mov_tipomovimiento', 20);

        // Genset 1
        $table->string('mov_genset_1', 50)->nullable();
        $table->string('mov_pvgenset_1', 50)->nullable();
        $table->date('mov_gensetfecha_1')->nullable();
        $table->decimal('mov_horometro_ingreso_1', 9, 1)->nullable();
        $table->decimal('mov_horometro_salida_1', 9, 1)->nullable();
        $table->decimal('mov_gal_salida_1', 5, 2)->nullable();
        $table->decimal('mov_gal_diferencia_1', 5, 2)->nullable();
        $table->decimal('mov_gal_ingreso_1', 5, 2)->nullable();
        $table->string('mov_marchamotanque_1', 50)->nullable();
        $table->string('mov_marchamopuerta_1', 50)->nullable();
        $table->string('mov_marchamopanel1_1', 50)->nullable();
        $table->string('mov_marchamopanel2_1', 50)->nullable();
        // Genset 2
        $table->string('mov_genset_2', 50)->nullable();
        $table->string('mov_pvgenset_2', 50)->nullable();
        $table->date('mov_gensetfecha_2')->nullable();
        $table->decimal('mov_horometro_ingreso_2', 9, 1)->nullable();
        $table->decimal('mov_horometro_salida_2', 9, 1)->nullable();
        $table->decimal('mov_gal_salida_2', 5, 2)->nullable();
        $table->decimal('mov_gal_diferencia_2', 5, 2)->nullable();
        $table->decimal('mov_gal_ingreso_2', 5, 2)->nullable();
        $table->string('mov_marchamotanque_2', 50)->nullable();
        $table->string('mov_marchamopuerta_2', 50)->nullable();
        $table->string('mov_marchamopanel1_2', 50)->nullable();
        $table->string('mov_marchamopanel2_2', 50)->nullable();

        // Observaciones
        $table->text('mov_observaciones')->nullable();

        // Inspecciones Chassis (bueno/malo) - enum para optimizar espacio
        $table->enum('mov_ch_suspension', ['bueno', 'malo'])->nullable();
        $table->enum('mov_ch_guardafangos', ['bueno', 'malo'])->nullable();
        $table->enum('mov_ch_patas', ['bueno', 'malo'])->nullable();
        $table->enum('mov_ch_luces', ['bueno', 'malo'])->nullable();
        $table->enum('mov_ch_seguridad', ['bueno', 'malo'])->nullable();
        $table->enum('mov_ch_estructura_general', ['bueno', 'malo'])->nullable();

        // Inspecciones Genset (bueno/malo) - enum para optimizar espacio
        $table->enum('mov_gs_puertas', ['bueno', 'malo'])->nullable();
        $table->enum('mov_gs_tapon', ['bueno', 'malo'])->nullable();
        $table->enum('mov_gs_argolla', ['bueno', 'malo'])->nullable();
        $table->enum('mov_gs_blindajes', ['bueno', 'malo'])->nullable();
        $table->enum('mov_gs_estructura_general', ['bueno', 'malo'])->nullable();

        // Llantas 1–12
        for ($i = 1; $i <= 12; $i++) {
            $col1 = $table->string("mov_llanta{$i}_quemado", 20);
            $col2 = $table->string("mov_llanta{$i}_profundidad", 20);
            $col3 = $table->string("mov_llanta{$i}_marca", 50);

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
