<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDeviceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'id_tipo_dispositivo' => [
                'required',
                'integer',
                'exists:device_types,id',
            ],

            'id_marca' => [
                'required',
                'integer',
                'exists:brands,id',
            ],

            'id_modelo' => [
                'required',
                'integer',
                'exists:models,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'id_tipo_dispositivo.required' => 'El campo id_tipo_dispositivo es requerido.',
            'id_tipo_dispositivo.integer' => 'El campo id_tipo_dispositivo debe ser un número entero.',
            'id_tipo_dispositivo.exists' => 'El valor del campo id_tipo_dispositivo no es válido.',

            'id_marca.required' => 'El campo id_marca es requerido.',
            'id_marca.integer' => 'El campo id_marca debe ser un número entero.',
            'id_marca.exists' => 'El valor del campo id_marca no es válido.',

            'id_modelo.required' => 'El campo id_modelo es requerido.',
            'id_modelo.integer' => 'El campo id_modelo debe ser un número entero.',
            'id_modelo.exists' => 'El valor del campo id_modelo no es válido.',
        ];
    }
}
