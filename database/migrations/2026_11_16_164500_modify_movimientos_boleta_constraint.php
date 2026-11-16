<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Modifica la tabla movimientos para permitir que una boleta se use en dos movimientos
     * diferentes: uno de salida y otro de ingreso.
     * 
     * - Remueve la restricción UNIQUE individual en mov_boleta
     * - Añade un índice único compuesto (mov_boleta, mov_tipomovimiento)
     * - Esto permite: 2026-0000001 salida + 2026-0000001 ingreso
     * - Pero impide: 2026-0000001 salida + 2026-0000001 salida (duplicado)
     */
    public function up(): void
    {
        Schema::table('movimientos', function (Blueprint $table) {
            // Remover la restricción UNIQUE actual en mov_boleta
            // Primero obtener el nombre de la restricción
            $table->dropUnique(['mov_boleta']);
            
            // Agregar índice único compuesto para permitir la reutilización
            // controlada entre tipos de movimiento
            $table->unique(['mov_boleta', 'mov_tipomovimiento'], 'unique_boleta_tipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movimientos', function (Blueprint $table) {
            // Remover el índice compuesto
            $table->dropUnique('unique_boleta_tipo');
            
            // Restaurar la restricción UNIQUE original
            $table->unique(['mov_boleta']);
        });
    }
};
