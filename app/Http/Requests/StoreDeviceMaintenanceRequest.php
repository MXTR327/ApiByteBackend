<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeviceMaintenanceRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_mantenimiento' => [
                'required',
                'integer',
                'exists:maintenances,id',
            ],

            'id_equipo' => [
                'required',
                'integer',
                'exists:devices,id',
            ],

            'precio_mantenimiento_equipo' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'motivo_mantenimiento' => [
                'required',
                'string',
            ],

            'detalles_equipo_extra' => [
                'nullable',
                'string',
            ],

            'estado_actual' => [
                'required',
                'string',
                'max:100',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'id_mantenimiento.required' => 'El campo id_mantenimiento es obligatorio.',
            'id_mantenimiento.integer' => 'El campo id_mantenimiento debe ser un número entero.',
            'id_mantenimiento.exists' => 'El campo id_mantenimiento debe ser un número entero.',

            'id_equipo.required' => 'El campo id_equipo es obligatorio.',
            'id_equipo.integer' => 'El campo id_equipo debe ser un número entero.',
            'id_equipo.exists' => 'El campo id_equipo no existe en la tabla equipos.',

            'precio_mantenimiento_equipo.numeric' => 'El campo precio_mantenimiento_equipo debe ser un número.',
            'precio_mantenimiento_equipo.min' => 'El campo precio_mantenimiento_equipo debe ser un número decimal.',

            'motivo_mantenimiento.required' => 'El campo motivo_mantenimiento es obligatorio.',
            'motivo_mantenimiento.string' => 'El campo motivo_mantenimiento debe ser una cadena de texto.',

            'importantes.string' => 'El campo importantes debe ser una cadena de texto.',

            'estado_equipo_mantenimiento.required' => 'El campo estado_equipo_mantenimiento es obligatorio.',
            'estado_equipo_mantenimiento.string' => 'El campo estado_equipo_mantenimiento debe ser una cadena de texto.',
            'estado_equipo_mantenimiento.max' => 'El campo estado_equipo_mantenimiento no debe tener más de 100 caracteres.',
        ];
    }
}
