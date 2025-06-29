<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaintenanceTransactionRequest extends FormRequest
{
    // Autoriza la solicitud, devuelve true para permitir todas las solicitudes
    public function authorize()
    {
        return true; // Cambia esto según tus necesidades de autorización
    }

    // Define las reglas de validación para los datos de entrada
    public function rules()
    {
        return [
            // Reglas para el campo id_cliente
            'id_cliente' => 'required|integer',
            // Reglas para el campo id_encargadoEntrega
            'id_encargadoEntrega' => 'required|integer',
            // Reglas para el campo equipos
            'equipos' => 'required|array',
            // Reglas para los campos dentro del arreglo equipos
            'equipos.*.id_entidad' => 'required|integer',
            'equipos.*.id_tipo_dispositivo' => 'required|integer',
            'equipos.*.id_marca' => 'required|integer',
            'equipos.*.nombre_modelo' => 'required|string',
            'equipos.*.numero_serie' => 'required|string',
            'equipos.*.precio_mantenimiento_equipo' => 'required|numeric',
            'equipos.*.motivo_mantenimiento' => 'required|string',
            'equipos.*.detalles_equipo_extra' => 'nullable|string',
            // Regla para el campo adelanto
            'adelanto' => 'nullable|numeric',
        ];
    }

    // Define los mensajes de error personalizados para las reglas de validación
    public function messages()
    {
        return [
            // Mensajes para el campo id_cliente
            'id_cliente.required' => 'El campo id_cliente es obligatorio.',
            'id_cliente.integer' => 'El campo id_cliente debe ser un número entero.',
            // Mensajes para el campo id_encargadoEntrega
            'id_encargadoEntrega.required' => 'El campo id_encargadoEntrega es obligatorio.',
            'id_encargadoEntrega.integer' => 'El campo id_encargadoEntrega debe ser un número entero.',
            // Mensajes para el campo equipos
            'equipos.required' => 'El campo equipos es obligatorio.',
            'equipos.array' => 'El campo equipos debe ser un arreglo.',
            // Mensajes para los campos dentro del arreglo equipos
            'equipos.*.id_entidad.required' => 'El campo id_entidad es obligatorio para cada equipo.',
            'equipos.*.id_entidad.integer' => 'El campo id_entidad debe ser un número entero.',

            'equipos.*.id_tipo_dispositivo.required' => 'El campo id_tipo_dispositivo es obligatorio para cada equipo.',
            'equipos.*.id_tipo_dispositivo.integer' => 'El campo id_tipo_dispositivo debe ser un número entero.',

            'equipos.*.id_marca.required' => 'El campo id_marca es obligatorio para cada equipo.',
            'equipos.*.id_marca.integer' => 'El campo id_marca debe ser un número entero.',

            'equipos.*.nombre_modelo.required' => 'El campo nombre_modelo es obligatorio para cada equipo.',

            'equipos.*.numero_serie.required' => 'El campo numero_serie es obligatorio para cada equipo.',

            'equipos.*.precio_mantenimiento_equipo.required' => 'El campo precio_mantenimiento_equipo es obligatorio para cada equipo.',
            'equipos.*.precio_mantenimiento_equipo.numeric' => 'El campo precio_mantenimiento_equipo debe ser un número.',

            'equipos.*.motivo_mantenimiento.required' => 'El campo motivo_mantenimiento es obligatorio para cada equipo.',

            'equipos.*.detalles_equipo_extra.string' => 'El campo detalles_equipo_extra debe ser una cadena de texto.',
            // Mensaje para el campo adelanto
            'adelanto.numeric' => 'El campo adelanto debe ser un número.',
        ];
    }
}
