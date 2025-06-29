<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreModelRequest extends FormRequest
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
            'nombre_modelo' => [
                'required',
                'string',
                'max:100',
            ],
            'id_marca' => [
                'required',
                'integer',
                'exists:brands,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_modelo.required' => 'El campo nombre_modelo es obligatorio.',
            'nombre_modelo.string' => 'El campo nombre_modelo debe ser una cadena de texto.',
            'nombre_modelo.max' => 'El campo nombre_modelo no puede exceder los 255 caracteres.',

            'id_marca.required' => 'El campo id_marca es obligatorio.',
            'id_marca.integer' => 'El campo id_marca debe ser un número entero.',
            'id_marca.exists' => 'El campo id_marca no existe en la tabla Marcas.',
        ];
    }
}
