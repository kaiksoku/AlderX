<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovimientoSalidaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Datos generales
            'mov_fecha' => 'required|date',
            'mov_hora' => 'required|date_format:H:i',
            'mov_cabezal' => 'required|string|max:255',
            'mov_placa_cabezal' => 'required|string|max:8|regex:/^C-[0-9]{3}[A-Z]{3}$/',
            'mov_kilometraje' => 'nullable|integer|min:0',

            // Contenedor
            'mov_contenedor' => 'nullable|string|max:11|regex:/^[A-Za-z]{4}[0-9]{7}$/',
            'mov_pv_contenedor' => 'nullable|string|max:255',
            'mov_pv_contenedor_fecha' => 'nullable|date',
            'mov_naviera' => 'nullable|string|max:255',
            'mov_setpoint' => 'nullable|string|max:255',
            'mov_damper' => 'nullable|string|max:255',
            'mov_sello_contenedor' => 'nullable|string|max:255',

            // Comercial
            'mov_contenido' => 'required|string|max:255',
            'mov_cliente' => 'nullable|string|max:255',
            'mov_destino' => 'nullable|string|max:255',
            'mov_conductor' => 'required|string|max:255',

            // Chassis
            'mov_chassis' => 'required|string|max:255',
            'mov_chass_placa' => 'nullable|string|max:8',
            'mov_pv_chassis' => 'nullable|string|max:255',
            'mov_fecha_pv_chassis' => 'nullable|date',
            'mov_hubodometro' => 'nullable|integer|min:0',

            // Condicionista y digitador
            'mov_condicionista' => 'required|integer|exists:users,id',
            'mov_digitador' => 'nullable|integer|exists:users,id',

            // Genset 1
            'gen_numero_1' => 'nullable|string|max:255',
            'gen_pv' => 'nullable|string|max:255',
            'gen_fecha_pv' => 'nullable|date',
            'gen_horometro_salida' => 'nullable|numeric|min:0',
            'gen_horometro_ingreso' => 'nullable|numeric|min:0',

            // Genset 2
            'gen_numero_2' => 'nullable|string|max:255',
            'gen_pv_2' => 'nullable|string|max:255',
            'gen_fecha_pv_2' => 'nullable|date',
            'gen_horometro_salida_2' => 'nullable|numeric|min:0',
            'gen_horometro_ingreso_2' => 'nullable|numeric|min:0',

            // Combustible 1
            'mov_comb_galones_salida' => 'nullable|numeric|min:0',
            'mov_comb_carga' => 'nullable|numeric|min:0',
            'mov_comb_nivel_ingreso' => 'nullable|numeric|min:0',
            'mov_comb_tanque' => 'nullable|string|max:255',
            'mov_comb_puerta' => 'nullable|string|max:255',
            'mov_comb_panel_1' => 'nullable|string|max:255',
            'mov_comb_panel_2' => 'nullable|string|max:255',

            // Combustible 2
            'mov_comb_galones_salida_2' => 'nullable|numeric|min:0',
            'mov_comb_carga_2' => 'nullable|numeric|min:0',
            'mov_comb_nivel_ingreso_2' => 'nullable|numeric|min:0',
            'mov_comb_tanque_2' => 'nullable|string|max:255',
            'mov_comb_puerta_2' => 'nullable|string|max:255',
            'mov_comb_panel_1_2' => 'nullable|string|max:255',
            'mov_comb_panel_2_2' => 'nullable|string|max:255',

            // Llantas (1-8 requeridas, 9-12 opcionales)
            'mov_llanta1_1' => 'required|integer|min:0',
            'mov_llanta1_2' => 'required|integer|min:0',
            'mov_llanta1_3' => 'required|string|max:255',
            'mov_llanta2_1' => 'required|integer|min:0',
            'mov_llanta2_2' => 'required|integer|min:0',
            'mov_llanta2_3' => 'required|string|max:255',
            'mov_llanta3_1' => 'required|integer|min:0',
            'mov_llanta3_2' => 'required|integer|min:0',
            'mov_llanta3_3' => 'required|string|max:255',
            'mov_llanta4_1' => 'required|integer|min:0',
            'mov_llanta4_2' => 'required|integer|min:0',
            'mov_llanta4_3' => 'required|string|max:255',
            'mov_llanta5_1' => 'required|integer|min:0',
            'mov_llanta5_2' => 'required|integer|min:0',
            'mov_llanta5_3' => 'required|string|max:255',
            'mov_llanta6_1' => 'required|integer|min:0',
            'mov_llanta6_2' => 'required|integer|min:0',
            'mov_llanta6_3' => 'required|string|max:255',
            'mov_llanta7_1' => 'required|integer|min:0',
            'mov_llanta7_2' => 'required|integer|min:0',
            'mov_llanta7_3' => 'required|string|max:255',
            'mov_llanta8_1' => 'required|integer|min:0',
            'mov_llanta8_2' => 'required|integer|min:0',
            'mov_llanta8_3' => 'required|string|max:255',
            'mov_llanta9_1' => 'nullable|integer|min:0',
            'mov_llanta9_2' => 'nullable|integer|min:0',
            'mov_llanta9_3' => 'nullable|string|max:255',
            'mov_llanta10_1' => 'nullable|integer|min:0',
            'mov_llanta10_2' => 'nullable|integer|min:0',
            'mov_llanta10_3' => 'nullable|string|max:255',
            'mov_llanta11_1' => 'nullable|integer|min:0',
            'mov_llanta11_2' => 'nullable|integer|min:0',
            'mov_llanta11_3' => 'nullable|string|max:255',
            'mov_llanta12_1' => 'nullable|integer|min:0',
            'mov_llanta12_2' => 'nullable|integer|min:0',
            'mov_llanta12_3' => 'nullable|string|max:255',

            // Observaciones
            'mov_observaciones' => 'nullable|string|max:5000',

            // Inspecciones Chassis (todos requeridos)
            'mov_ch_suspension' => 'required|in:bueno,malo',
            'mov_ch_guardafangos' => 'required|in:bueno,malo',
            'mov_ch_patas' => 'required|in:bueno,malo',
            'mov_ch_luces' => 'required|in:bueno,malo',
            'mov_ch_seguridad' => 'required|in:bueno,malo',
            'mov_ch_estructura_general' => 'required|in:bueno,malo',

            // Inspecciones Genset (todos requeridos)
            'mov_gs_puertas' => 'required|in:bueno,malo',
            'mov_gs_tapon' => 'required|in:bueno,malo',
            'mov_gs_argolla' => 'required|in:bueno,malo',
            'mov_gs_blindajes' => 'required|in:bueno,malo',
            'mov_gs_estructura_general' => 'required|in:bueno,malo',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'mov_fecha.required' => 'La fecha es requerida',
            'mov_hora.required' => 'La hora es requerida',
            'mov_cabezal.required' => 'El cabezal es requerido',
            'mov_placa_cabezal.required' => 'La placa del cabezal es requerida',
            'mov_placa_cabezal.regex' => 'El formato de placa debe ser C-123ABC',
            'mov_contenido.required' => 'El contenido del contenedor es requerido',
            'mov_conductor.required' => 'El conductor es requerido',
            'mov_chassis.required' => 'El chassis es requerido',
            'mov_condicionista.required' => 'Debe seleccionar un condicionista',
        ];
    }
}
