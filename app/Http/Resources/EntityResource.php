<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EntityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tipo_entidad' => $this->tipo_entidad,
            'nombre_entidad' => $this->nombre_entidad,
            'direccion_entidad' => $this->direccion_entidad,
            'referencia_direccion_entidad' => $this->referencia_direccion_entidad,
            'telefono_entidad' => $this->telefono_entidad,
            'identificacion_entidad' => $this->identificacion_entidad,
            'tipo_identificacion_entidad' => $this->tipo_identificacion_entidad,
            'id_entidad_padre' => $this->id_entidad_padre,
        ];
    }
}
