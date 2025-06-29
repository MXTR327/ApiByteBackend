<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaintenanceRequest extends FormRequest
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
            'id_responsable_de_dejar_equipo' => [
                'required',
                'string',
                'max:11',
            ],

            'adelanto_mantenimiento' => [
                'required',
                'numeric',
                'min:0',
            ],

            'fecha_salida_mantenimiento' => [
                'nullable',
                'date',
            ],

            'estado_mantenimiento' => [
                'required',
                'string',
                'max:100',
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'identificacion_responsable_de_dejar_equipo.required' => 'El campo identificacion_responsable_de_dejar_equipo es obligatorio.',
            'identificacion_responsable_de_dejar_equipo.string' => 'El campo identificacion_responsable_de_dejar_equipo debe ser una cadena de caracteres.',
            'identificacion_responsable_de_dejar_equipo.max' => 'El campo identificacion_responsable_de_dejar_equipo no puede tener más de 11 caracteres.',

            'adelanto_mantenimiento.required' => 'El campo adelanto_mantenimiento es obligatorio.',
            'adelanto_mantenimiento.numeric' => 'El campo adelanto_mantenimiento debe ser un número.',
            'adelanto_mantenimiento.min' => 'El campo adelanto_mantenimiento debe ser mayor o igual a 0.',

            'fecha_salida_mantenimiento.date' => 'El campo fecha_salida_mantenimiento debe ser una fecha válida.',

            'estado_mantenimiento.required' => 'El campo estado_mantenimiento es obligatorio.',
            'estado_mantenimiento.string' => 'El campo estado_mantenimiento debe ser una cadena de caracteres.',
            'estado_mantenimiento.max' => 'El campo estado_mantenimiento no puede tener más de 100 caracteres.',
        ];
    }
}
