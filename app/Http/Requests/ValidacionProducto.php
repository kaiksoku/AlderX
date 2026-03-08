<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidacionProducto extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a hacer esta solicitud.
     */
    public function authorize()
    {
        return true; // Permitir que cualquiera use esta validación, puedes ajustarlo según permisos
    }

    /**
     * Reglas de validación.
     */
    public function rules()
    {
        return [
        'prod_nombre' => 'required|string|max:255',
        'prod_descripcion' => 'nullable|string|max:255',
        'prod_codigo'=> 'required|numeric',
        'prod_cantidad' => 'required|numeric',
        'prod_precio' => 'required|numeric',
        'prod_categoria' => 'required',
        ];
    }
}
