<?php

namespace App\Models;

use App\Models\Device;
use App\Models\Maintenance;
use App\Models\StateHistory;
use App\Models\MaintenanceTask;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeviceMaintenance extends Model
{
    use HasFactory;

    protected $table = 'device_maintenances';

    protected $fillable = [
        'id_equipo',
        'id_mantenimiento',
        'serie',
        'precio_mantenimiento_equipo',
        'motivo_mantenimiento',
        'condiciones_fisicas',
        'detalles_equipo_extra',
        'diagnostico_equipo',
        'estado_actual',
    ];

    // Relaciones
    public function device()
    {
        return $this->belongsTo(Device::class, 'id_equipo');
    }

    public function maintenance()
    {
        return $this->belongsTo(Maintenance::class, 'id_mantenimiento');
    }

    public function stateHistories()
    {
        return $this->hasMany(StateHistory::class, 'id_equipo_mantenimiento');
    }

    public function maintenanceTasks()
    {
        return $this->hasMany(MaintenanceTask::class, 'id_equipo_mantenimiento');
    }

    public function trabajoARealizar()
    {
        return $this->hasMany(MaintenanceTask::class, 'id_equipo_mantenimiento')->where('estado', false);
    }

    public function trabajoRealizado()
    {
        return $this->hasMany(MaintenanceTask::class, 'id_equipo_mantenimiento')->where('estado', true);
    }

    // Actualiza el estado_actual basado en las tareas relacionadas.
    public function updateEstadoActual($excludeTaskId = null)
    {
        $query = $this->maintenanceTasks()->where('estado', false);

        if ($excludeTaskId) {
            $query->where('id', '!=', $excludeTaskId);
        }

        $pendingTasks = $query->count();

        // Determina el nuevo estado
        $nuevoEstado = $pendingTasks > 0 ? 'En Proceso' : 'Finalizado';

        // Cambia el estado solo si realmente ha cambiado
        if ($this->estado_actual !== $nuevoEstado) {
            $this->update(['estado_actual' => $nuevoEstado]);
        }

        // Notifica al mantenimiento relacionado
        if ($this->maintenance) {
            $this->maintenance->updateEstadoMantenimiento();
        }
    }


    // Crea un historial de estado cada vez que se actualiza el estado_actual.
    protected static function boot()
    {
        parent::boot();

        // Al crear un nuevo DeviceMaintenance
        static::created(function ($deviceMaintenance) {
            // Crear un registro en StateHistory
            StateHistory::create([
                'id_equipo_mantenimiento' => $deviceMaintenance->id,
                'estado' => 'Pendiente',
                'notas_historial' => 'Estado inicial al crear mantenimiento',
                'anexo' => null,
            ]);
        });

        // Al actualizar el estado de DeviceMaintenance
        static::updated(function ($deviceMaintenance) {
            // Crear un registro en StateHistory solo si cambia el estado_actual
            if ($deviceMaintenance->wasChanged('estado_actual')) {
                StateHistory::create([
                    'id_equipo_mantenimiento' => $deviceMaintenance->id,
                    'estado' => $deviceMaintenance->estado_actual,
                    'notas_historial' => 'Cambio automático de estado',
                    'anexo' => null,
                ]);
            }
        });
    }
}
