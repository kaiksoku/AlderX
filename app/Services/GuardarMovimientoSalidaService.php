<?php

namespace App\Services;

use App\Models\Movimiento;
use App\Services\TicketNumberService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * Servicio para guardar movimientos de salida
 * 
 * Encapsula la lógica de:
 * - Generación de boleta usando TicketNumberService
 * - Validación de datos
 * - Guardado de movimiento con transacción
 * - Manejo de errores y rollback
 */
class GuardarMovimientoSalidaService
{
    protected TicketNumberService $ticketService;

    public function __construct(TicketNumberService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    /**
     * Guarda un movimiento de salida
     * 
     * @param array $datos Array con todos los datos del formulario
     * @return array Array con status, boleta y mensaje
     * @throws Exception Si hay error durante el guardado
     */
    public function guardar(array $datos): array
    {
        try {
            return DB::transaction(function () use ($datos) {
                // 1. Generar boleta segura
                $boleta = $this->ticketService->generateTicketNumber();
                
                // 2. Preparar datos para guardado
                $datosMovimiento = $this->prepararDatos($datos, $boleta);
                
                // 3. Guardar movimiento con todas las inspecciones incluidas
                $movimiento = Movimiento::create($datosMovimiento);
                
                Log::info('Movimiento de salida guardado exitosamente', [
                    'mov_id' => $movimiento->mov_id,
                    'mov_boleta' => $boleta,
                    'mov_tipomovimiento' => 'salida',
                    'user_id' => auth()->id(),
                ]);

                return [
                    'status' => 'success',
                    'boleta' => $boleta,
                    'mov_id' => $movimiento->mov_id,
                    'mensaje' => "Movimiento de salida registrado exitosamente. Boleta: {$boleta}",
                ];
            });
        } catch (Exception $e) {
            Log::error('Error al guardar movimiento de salida', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);

            throw new Exception("Error al guardar movimiento: " . $e->getMessage());
        }
    }

    /**
     * Prepara los datos del formulario para insertar en la base de datos
     * 
     * @param array $datos Datos del formulario
     * @param string $boleta Número de boleta generado
     * @return array Datos listos para Movimiento::create()
     */
    protected function prepararDatos(array $datos, string $boleta): array
    {
        return [
            // Datos generales
            'mov_boleta' => $boleta,
            'mov_fecha' => $datos['mov_fecha'] ?? null,
            'mov_hora' => $datos['mov_hora'] ?: now()->format('H:i'),
            'mov_recinto' => auth()->user()->recinto,
            'mov_condicionista' => $datos['mov_condicionista'] ?? null,
            'mov_digitador' => auth()->id(),
            'mov_tipomovimiento' => 'salida',

            // Cabezal
            'mov_cabezal' => $datos['mov_cabezal'] ?? null,
            'mov_placacabezal' => $datos['mov_placa_cabezal'] ?? null,
            'mov_kilometraje' => $datos['mov_kilometraje'] ?? null,

            // Contenedor
            'mov_contenedor' => $datos['mov_contenedor'] ?? null,
            'mov_pvcontenedor' => $datos['mov_pv_contenedor'] ?? null,
            'mov_contenedorfecha' => $datos['mov_pv_contenedor_fecha'] ?? null,
            'mov_naviera' => $datos['mov_naviera'] ?? null,
            'mov_setpoint' => $datos['mov_setpoint'] ?? null,
            'mov_damper' => $datos['mov_damper'] ?? null,
            'mov_sellocontenedor' => $datos['mov_sello_contenedor'] ?? null,

            // Comercial
            'mov_contenido' => $datos['mov_contenido'] ?? null,
            'mov_cliente' => $datos['mov_cliente'] ?? null,
            'mov_conductor' => $datos['mov_conductor'] ?? null,

            // Chassis
            'mov_chassis' => $datos['mov_chassis'] ?? null,
            'mov_placachassis' => $datos['mov_chass_placa'] ?? null,
            'mov_pvchassis' => $datos['mov_pv_chassis'] ?? null,
            'mov_chassisfecha' => $datos['mov_fecha_pv_chassis'] ?? null,
            'mov_hubodometro' => $datos['mov_hubodometro'] ?? null,

            // Genset 1
            'mov_genset_1' => $datos['gen_numero_1'] ?? null,
            'mov_pvgenset_1' => $datos['gen_pv'] ?? null,
            'mov_gensetfecha_1' => $datos['gen_fecha_pv'] ?? null,
            'mov_horometro_salida_1' => $datos['gen_horometro_salida'] ?? null,
            'mov_horometro_ingreso_1' => $datos['gen_horometro_ingreso'] ?? null,
            'mov_gal_salida_1' => $datos['mov_comb_galones_salida'] ?? null,
            'mov_gal_diferencia_1' => $this->calcularDiferenciaCombustible(
                $datos['mov_comb_galones_salida'] ?? 0,
                $datos['mov_comb_carga'] ?? 0
            ),
            'mov_gal_ingreso_1' => $datos['mov_comb_nivel_ingreso'] ?? null,
            'mov_marchamotanque_1' => $datos['mov_comb_tanque'] ?? null,
            'mov_marchamopuerta_1' => $datos['mov_comb_puerta'] ?? null,
            'mov_marchamopanel1_1' => $datos['mov_comb_panel_1'] ?? null,
            'mov_marchamopanel2_1' => $datos['mov_comb_panel_2'] ?? null,

            // Genset 2
            'mov_genset_2' => $datos['gen_numero_2'] ?? null,
            'mov_pvgenset_2' => $datos['gen_pv_2'] ?? null,
            'mov_gensetfecha_2' => $datos['gen_fecha_pv_2'] ?? null,
            'mov_horometro_salida_2' => $datos['gen_horometro_salida_2'] ?? null,
            'mov_horometro_ingreso_2' => $datos['gen_horometro_ingreso_2'] ?? null,
            'mov_gal_salida_2' => $datos['mov_comb_galones_salida_2'] ?? null,
            'mov_gal_diferencia_2' => $this->calcularDiferenciaCombustible(
                $datos['mov_comb_galones_salida_2'] ?? 0,
                $datos['mov_comb_carga_2'] ?? 0
            ),
            'mov_gal_ingreso_2' => $datos['mov_comb_nivel_ingreso_2'] ?? null,
            'mov_marchamotanque_2' => $datos['mov_comb_tanque_2'] ?? null,
            'mov_marchamopuerta_2' => $datos['mov_comb_puerta_2'] ?? null,
            'mov_marchamopanel1_2' => $datos['mov_comb_panel_1_2'] ?? null,
            'mov_marchamopanel2_2' => $datos['mov_comb_panel_2_2'] ?? null,

            // Llantas
            'mov_llanta1_quemado' => $datos['mov_llanta1_1'] ?? null,
            'mov_llanta1_profundidad' => $datos['mov_llanta1_2'] ?? null,
            'mov_llanta1_marca' => $datos['mov_llanta1_3'] ?? null,
            'mov_llanta2_quemado' => $datos['mov_llanta2_1'] ?? null,
            'mov_llanta2_profundidad' => $datos['mov_llanta2_2'] ?? null,
            'mov_llanta2_marca' => $datos['mov_llanta2_3'] ?? null,
            'mov_llanta3_quemado' => $datos['mov_llanta3_1'] ?? null,
            'mov_llanta3_profundidad' => $datos['mov_llanta3_2'] ?? null,
            'mov_llanta3_marca' => $datos['mov_llanta3_3'] ?? null,
            'mov_llanta4_quemado' => $datos['mov_llanta4_1'] ?? null,
            'mov_llanta4_profundidad' => $datos['mov_llanta4_2'] ?? null,
            'mov_llanta4_marca' => $datos['mov_llanta4_3'] ?? null,
            'mov_llanta5_quemado' => $datos['mov_llanta5_1'] ?? null,
            'mov_llanta5_profundidad' => $datos['mov_llanta5_2'] ?? null,
            'mov_llanta5_marca' => $datos['mov_llanta5_3'] ?? null,
            'mov_llanta6_quemado' => $datos['mov_llanta6_1'] ?? null,
            'mov_llanta6_profundidad' => $datos['mov_llanta6_2'] ?? null,
            'mov_llanta6_marca' => $datos['mov_llanta6_3'] ?? null,
            'mov_llanta7_quemado' => $datos['mov_llanta7_1'] ?? null,
            'mov_llanta7_profundidad' => $datos['mov_llanta7_2'] ?? null,
            'mov_llanta7_marca' => $datos['mov_llanta7_3'] ?? null,
            'mov_llanta8_quemado' => $datos['mov_llanta8_1'] ?? null,
            'mov_llanta8_profundidad' => $datos['mov_llanta8_2'] ?? null,
            'mov_llanta8_marca' => $datos['mov_llanta8_3'] ?? null,
            'mov_llanta9_quemado' => $datos['mov_llanta9_1'] ?? null,
            'mov_llanta9_profundidad' => $datos['mov_llanta9_2'] ?? null,
            'mov_llanta9_marca' => $datos['mov_llanta9_3'] ?? null,
            'mov_llanta10_quemado' => $datos['mov_llanta10_1'] ?? null,
            'mov_llanta10_profundidad' => $datos['mov_llanta10_2'] ?? null,
            'mov_llanta10_marca' => $datos['mov_llanta10_3'] ?? null,
            'mov_llanta11_quemado' => $datos['mov_llanta11_1'] ?? null,
            'mov_llanta11_profundidad' => $datos['mov_llanta11_2'] ?? null,
            'mov_llanta11_marca' => $datos['mov_llanta11_3'] ?? null,
            'mov_llanta12_quemado' => $datos['mov_llanta12_1'] ?? null,
            'mov_llanta12_profundidad' => $datos['mov_llanta12_2'] ?? null,
            'mov_llanta12_marca' => $datos['mov_llanta12_3'] ?? null,

            // Observaciones
            'mov_observaciones' => $datos['mov_observaciones'] ?? null,

            // Inspecciones Chassis
            'mov_ch_suspension' => $datos['mov_ch_suspension'] ?? null,
            'mov_ch_guardafangos' => $datos['mov_ch_guardafangos'] ?? null,
            'mov_ch_patas' => $datos['mov_ch_patas'] ?? null,
            'mov_ch_luces' => $datos['mov_ch_luces'] ?? null,
            'mov_ch_seguridad' => $datos['mov_ch_seguridad'] ?? null,
            'mov_ch_estructura_general' => $datos['mov_ch_estructura_general'] ?? null,

            // Inspecciones Genset
            'mov_gs_puertas' => $datos['mov_gs_puertas'] ?? null,
            'mov_gs_tapon' => $datos['mov_gs_tapon'] ?? null,
            'mov_gs_argolla' => $datos['mov_gs_argolla'] ?? null,
            'mov_gs_blindajes' => $datos['mov_gs_blindajes'] ?? null,
            'mov_gs_estructura_general' => $datos['mov_gs_estructura_general'] ?? null,
        ];
    }

    /**
     * Calcula la diferencia de combustible (galones salida - galones cargados)
     */
    protected function calcularDiferenciaCombustible(?float $salida, ?float $cargados): ?float
    {
        if ($salida === null || $cargados === null) {
            return null;
        }

        return $salida - $cargados;
    }

    /**
     * Guarda las inspecciones de chassis y genset en sus tablas separadas
     */
    protected function guardarInspecciones(Movimiento $movimiento, array $datos): void
    {
        // Guardar inspecciones de chassis - Convertir 'bueno'/'malo' a 'B'/'M'
        DB::table('inspecciones_chassis')->insert([
            'mov_id' => $movimiento->mov_id,
            'suspension' => $this->sanitizarInspeccion($datos['mov_ch_suspension'] ?? null),
            'guardafangos' => $this->sanitizarInspeccion($datos['mov_ch_guardafangos'] ?? null),
            'patas' => $this->sanitizarInspeccion($datos['mov_ch_patas'] ?? null),
            'luces' => $this->sanitizarInspeccion($datos['mov_ch_luces'] ?? null),
            'seguridad' => $this->sanitizarInspeccion($datos['mov_ch_seguridad'] ?? null),
            'estructura_general' => $this->sanitizarInspeccion($datos['mov_ch_estructura_general'] ?? null),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Guardar inspecciones de genset - Convertir 'bueno'/'malo' a 'B'/'M'
        DB::table('inspecciones_genset')->insert([
            'mov_id' => $movimiento->mov_id,
            'puertas' => $this->sanitizarInspeccion($datos['mov_gs_puertas'] ?? null),
            'tapon' => $this->sanitizarInspeccion($datos['mov_gs_tapon'] ?? null),
            'argolla' => $this->sanitizarInspeccion($datos['mov_gs_argolla'] ?? null),
            'blindajes' => $this->sanitizarInspeccion($datos['mov_gs_blindajes'] ?? null),
            'estructura_general' => $this->sanitizarInspeccion($datos['mov_gs_estructura_general'] ?? null),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Convierte 'bueno' a 'B' y 'malo' a 'M'
     */
    protected function sanitizarInspeccion(?string $valor): ?string
    {
        if ($valor === null) {
            return null;
        }

        return match (strtolower($valor)) {
            'bueno' => 'B',
            'malo' => 'M',
            default => $valor[0] ?? null,
        };
    }
}
