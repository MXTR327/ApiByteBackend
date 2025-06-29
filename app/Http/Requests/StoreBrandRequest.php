<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre_marca' => [
                'required',
                'string',
                'max:100',
            ],
            'id_tipo_dispositivo' => [
                'required',
                'integer',
                'exists:device_types,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_marca.required' => 'El campo nombre de la marca es obligatorio.',
            'nombre_marca.string' => 'El campo nombre de la marca debe ser una cadena de texto.',
            'nombre_marca.max' => 'El campo nombre de la marca no puede exceder los 255 caracteres.',

            'id_tipo_dispositivo.required' => 'El campo id_tipo_dispositivo es obligatorio.',
            'id_tipo_dispositivo.integer' => 'El campo id_tipo_dispositivo debe ser un número entero.',
            'id_tipo_dispositivo.exists' => 'El campo id_tipo_dispositivo no existe en la tabla tipo dispositvos.',
        ];
    }
}
