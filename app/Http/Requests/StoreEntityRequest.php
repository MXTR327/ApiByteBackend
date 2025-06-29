<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class StoreEntityRequest extends FormRequest
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
            'tipo_entidad' => [
                'required',
                'string',
                'max:50',
            ],

            'identificacion_entidad' => [
                'required',
                'string',
                'max:11',
                Rule::unique('entities', 'identificacion_entidad')->ignore($this->input('id')),
            ],

            'nombre_entidad' => [
                'required',
                'string',
                'max:255',
            ],

            'telefono_entidad' => [
                'required',
                'string',
                'max:15',
            ],

            'direccion_entidad' => [
                'required',
                'string',
            ],

            'referencia_direccion_entidad' => [
                'nullable',
                'string',
            ],

            'tipo_identificacion_entidad' => [
                'required',
                'string',
                'max:100',
            ],

            'id_entidad_padre' => [
                'nullable',
                'integer',
                'exists:entities,id',
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'tipo_entidad.required' => 'El campo tipo_entidad de la entidad es obligatorio.',
            'tipo_entidad.string' => 'El campo tipo_entidad de la entidad debe ser una cadena de texto.',
            'tipo_entidad.max' => 'El campo tipo_entidad de la entidad no puede exceder los 50 caracteres.',

            'identificacion_entidad.required' => 'El campo identificacion_entidad de la entidad es obligatorio.',
            'identificacion_entidad.string' => 'El campo identificacion_entidad de la entidad debe ser una cadena de texto.',
            'identificacion_entidad.max' => 'El campo identificacion_entidad de la entidad no puede exceder los 11 caracteres.',
            'identificacion_entidad.unique' => 'El campo identificacion_entidad de la entidad ya existe.',

            'nombre_entidad.required' => 'El campo nombre_entidad de la entidad es obligatorio.',
            'nombre_entidad.string' => 'El campo nombre_entidad de la entidad debe ser una cadena de texto.',
            'nombre_entidad.max' => 'El campo nombre_entidad de la entidad no puede exceder los 255 caracteres.',

            'telefono_entidad.required' => 'El campo telefono_entidad de la entidad es obligatorio.',
            'telefono_entidad.string' => 'El campo telefono_entidad de la entidad debe ser una cadena de texto.',
            'telefono_entidad.max' => 'El campo telefono_entidad de la entidad no puede exceder los 15 caracteres.',

            'direccion_entidad.required' => 'El campo de la direccion de la entidad es obligatorio.',
            'direccion_entidad.string' => 'El campo direccion_entidad de la entidad debe ser una cadena de texto.',

            'referencia_direccion_entidad.string' => 'El campo referencia_direccion_entidad de la entidad debe ser una cadena de texto.',

            'tipo_identificacion_entidad.required' => 'El campo de la tipo_identificacion_entidad de la entidad es obligatorio.',
            'tipo_identificacion_entidad.string' => 'El campo tipo_identificacion_entidad de la entidad debe ser una cadena de texto.',
            'tipo_identificacion_entidad.max' => 'El campo tipo_identificacion_entidad de la entidad no puede exceder los 100 caracteres.',

            'id_entidad_padre.integer' => 'El campo id_entidad_padre de la entidad debe ser un número entero.',
            'id_entidad_padre.exists' => 'El campo id_entidad_padre de la entidad debe existir en la tabla entities.',
        ];
    }
}
