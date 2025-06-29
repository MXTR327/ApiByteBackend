<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Entity;
use App\Models\DeviceMaintenance;

class Maintenance extends Model
{
    use HasFactory;

    protected $table = 'maintenances';

    protected $fillable = [
        'adelanto_mantenimiento',
        'total_mantenimiento',
        'saldo_restante',
        'id_entidad',
        'id_recoge',
        'estado_mantenimiento',
    ];

    public function cliente()
    {
        return $this->belongsTo(Entity::class, 'id_entidad');
    }

    public function clienteRecoge()
    {
        return $this->belongsTo(Entity::class, 'id_recoge');
    }

    public function devicesMaintenance()
    {
        return $this->hasMany(DeviceMaintenance::class, 'id_mantenimiento');
    }

    // Actualiza el estado del mantenimiento basado en el estado de los DeviceMaintenance relacionados.
    public function updateEstadoMantenimiento()
    {
        $deviceMaintenances = $this->devicesMaintenance;

        // Determina el nuevo estado basado en los dispositivos relacionados
        if ($deviceMaintenances->contains('estado_actual', 'En Proceso')) {
            $nuevoEstado = 'En Proceso';
        } elseif ($deviceMaintenances->every(fn($dm) => $dm->estado_actual === 'Finalizado')) {
            $nuevoEstado = 'Finalizado';
        } else {
            $nuevoEstado = 'Pendiente';
        }

        // Verifica si el estado realmente ha cambiado antes de guardar
        if ($this->estado_mantenimiento !== $nuevoEstado) {
            $this->update(['estado_mantenimiento' => $nuevoEstado]);
        }
    }

    // Cambia el estado del mantenimiento, validando las transiciones permitidas.
    public function setEstado(string $nuevoEstado)
    {
        $validTransitions = [
            'Pendiente' => ['En Proceso'],
            'En Proceso' => ['Finalizado'],
            'Finalizado' => ['Entregado'],
            'Entregado' => [], // Estado final, no puede transitar a otros estados
        ];

        $estadoActual = $this->estado_mantenimiento;

        if (!isset($validTransitions[$estadoActual]) || !in_array($nuevoEstado, $validTransitions[$estadoActual])) {
            throw new \InvalidArgumentException("Transición de estado no permitida: {$estadoActual} a {$nuevoEstado}");
        }

        $this->update(['estado_mantenimiento' => $nuevoEstado]);
    }
}
