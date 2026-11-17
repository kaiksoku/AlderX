<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Modelo Movimiento
 * 
 * Representa un movimiento de entrada o salida de equipo/contenedor.
 * Cada boleta puede tener dos registros: uno de salida (apertura) y otro de ingreso (cierre).
 */
class Movimiento extends Model
{
    use HasFactory;

    protected $table = 'movimientos';
    protected $primaryKey = 'mov_id';

    public $incrementing = true;
    protected $keyType = 'int';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        // Datos generales
        'mov_boleta',
        'mov_fecha',
        'mov_hora',
        'mov_recinto',
        'mov_condicionista',
        'mov_digitador',
        'mov_tipomovimiento',

        // Cabezal
        'mov_cabezal',
        'mov_placacabezal',
        'mov_kilometraje',

        // Contenedor
        'mov_contenedor',
        'mov_pvcontenedor',
        'mov_contenedorfecha',
        'mov_naviera',
        'mov_setpoint',
        'mov_damper',
        'mov_sellocontenedor',

        // Información general
        'mov_contenido',
        'mov_cliente',
        'mov_conductor',

        // Chassis
        'mov_chassis',
        'mov_placachassis',
        'mov_pvchassis',
        'mov_chassisfecha',
        'mov_hubodometro',

        // Genset 1
        'mov_genset_1',
        'mov_pvgenset_1',
        'mov_gensetfecha_1',
        'mov_horometro_ingreso_1',
        'mov_horometro_salida_1',
        'mov_gal_salida_1',
        'mov_gal_diferencia_1',
        'mov_gal_ingreso_1',
        'mov_marchamotanque_1',
        'mov_marchamopuerta_1',
        'mov_marchamopanel1_1',
        'mov_marchamopanel2_1',

        // Genset 2
        'mov_genset_2',
        'mov_pvgenset_2',
        'mov_gensetfecha_2',
        'mov_horometro_ingreso_2',
        'mov_horometro_salida_2',
        'mov_gal_salida_2',
        'mov_gal_diferencia_2',
        'mov_gal_ingreso_2',
        'mov_marchamotanque_2',
        'mov_marchamopuerta_2',
        'mov_marchamopanel1_2',
        'mov_marchamopanel2_2',

        // Llantas (1-12, 3 campos cada una: quemado, profundidad, marca)
        'mov_llanta1_quemado',
        'mov_llanta1_profundidad',
        'mov_llanta1_marca',
        'mov_llanta2_quemado',
        'mov_llanta2_profundidad',
        'mov_llanta2_marca',
        'mov_llanta3_quemado',
        'mov_llanta3_profundidad',
        'mov_llanta3_marca',
        'mov_llanta4_quemado',
        'mov_llanta4_profundidad',
        'mov_llanta4_marca',
        'mov_llanta5_quemado',
        'mov_llanta5_profundidad',
        'mov_llanta5_marca',
        'mov_llanta6_quemado',
        'mov_llanta6_profundidad',
        'mov_llanta6_marca',
        'mov_llanta7_quemado',
        'mov_llanta7_profundidad',
        'mov_llanta7_marca',
        'mov_llanta8_quemado',
        'mov_llanta8_profundidad',
        'mov_llanta8_marca',
        'mov_llanta9_quemado',
        'mov_llanta9_profundidad',
        'mov_llanta9_marca',
        'mov_llanta10_quemado',
        'mov_llanta10_profundidad',
        'mov_llanta10_marca',
        'mov_llanta11_quemado',
        'mov_llanta11_profundidad',
        'mov_llanta11_marca',
        'mov_llanta12_quemado',
        'mov_llanta12_profundidad',
        'mov_llanta12_marca',

        // Observaciones
        'mov_observaciones',

        // Inspecciones Chassis
        'mov_ch_suspension',
        'mov_ch_guardafangos',
        'mov_ch_patas',
        'mov_ch_luces',
        'mov_ch_seguridad',
        'mov_ch_estructura_general',

        // Inspecciones Genset
        'mov_gs_puertas',
        'mov_gs_tapon',
        'mov_gs_argolla',
        'mov_gs_blindajes',
        'mov_gs_estructura_general',
    ];

    // Relaciones
    public function recinto()
    {
        return $this->belongsTo(Recintos::class, 'mov_recinto', 'reci_id');
    }

    public function condicionista()
    {
        return $this->belongsTo(User::class, 'mov_condicionista', 'id');
    }

    public function digitador()
    {
        return $this->belongsTo(User::class, 'mov_digitador', 'id');
    }

    /**
     * Obtiene el movimiento complementario (ingreso si esta es salida, o salida si esta es ingreso)
     */
    public function movimientoComplementario()
    {
        $tipoComplementario = $this->mov_tipomovimiento === 'salida' ? 'ingreso' : 'salida';
        
        return self::where('mov_boleta', $this->mov_boleta)
            ->where('mov_tipomovimiento', $tipoComplementario)
            ->first();
    }

    /**
     * Verifica si esta es una salida
     */
    public function esSalida(): bool
    {
        return $this->mov_tipomovimiento === 'salida';
    }

    /**
     * Verifica si esta es un ingreso
     */
    public function esIngreso(): bool
    {
        return $this->mov_tipomovimiento === 'ingreso';
    }

    /**
     * Obtiene todos los movimientos de una boleta específica
     */
    public static function porBoleta(string $boleta)
    {
        return self::where('mov_boleta', $boleta)->get();
    }
}
