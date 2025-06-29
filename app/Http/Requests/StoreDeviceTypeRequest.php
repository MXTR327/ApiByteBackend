<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDeviceTypeRequest extends FormRequest
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
            'tipo_dispositivo' => [
                'required',
                'string',
                'max:100',
                Rule::unique('device_types', 'tipo_dispositivo')->ignore($this->input('id')),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'tipo_dispositivo.required' => 'El campo de la DeviceType es obligatorio.',
            'tipo_dispositivo.string' => 'El campo tipo_dispositivo de la DeviceType debe ser una cadena de texto.',
            'tipo_dispositivo.max' => 'El campo tipo_dispositivo de la DeviceType no puede exceder los 255 caracteres.',
            'tipo_dispositivo.unique' => 'Esta campo tipo_dispositivo ya se registro anteriormente.',
        ];
    }
}
