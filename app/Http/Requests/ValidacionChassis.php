<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidacionChassis extends FormRequest
{
    /**
     * Autorizar la solicitud
     */
    public function authorize(): bool
    {
        return true; // luego puedes validar permisos si quieres
    }

    /**
     * Reglas de validación
     */
    public function rules(): array
    {
        return [

            'chass_numero' => [
                'required',
                'digits:4',
                'unique:chassis,chass_numero'
            ],

            'chass_placa' => [
                'required',
                'string',
                'max:8',
                'unique:chassis,chass_placa'
            ],

            'chass_ejes' => [
                'required',
                'integer',
                'in:2,3'
            ],

            'chass_medida' => [
                'required',
                'integer',
                'in:20,40'
            ],

            'chass_estructura' => [
                'nullable',
                'string',
                'max:255'
            ],

            'chass_estado' => [
                'required',
                'in:Disponible,Taller'
            ],

        ];
    }

    /**
     * Mensajes personalizados (opcional pero recomendado)
     */
    public function messages(): array
    {
        return [
            'chass_numero.required' => 'El número de chassis es obligatorio.',
            'chass_numero.digits' => 'El número de chassis debe tener 4 dígitos.',
            'chass_numero.unique' => 'Este chassis ya está registrado.',

            'chass_placa.required' => 'La placa es obligatoria.',
            'chass_placa.unique' => 'Esta placa ya está registrada.',

            'chass_ejes.in' => 'Los ejes solo pueden ser 2 o 3.',
            'chass_medida.in' => 'La medida solo puede ser 20 o 40.',
            'chass_estado.in' => 'El estado solo puede ser Disponible o Taller.',
        ];
    }
}
