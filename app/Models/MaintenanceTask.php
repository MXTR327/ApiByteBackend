<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\DeviceMaintenance;

class MaintenanceTask extends Model
{
    use HasFactory;
    protected $table = 'maintenance_tasks';

    protected $fillable = [
        'id_equipo_mantenimiento',
        'tarea_mantenimiento',
        'estado',
    ];

    public function deviceMaintenance()
    {
        return $this->belongsTo(DeviceMaintenance::class, 'id_equipo_mantenimiento');
    }

    protected static function booted()
    {
        static::updating(function ($task) {
            // Si el estado cambia de false a true
            if (!$task->getOriginal('estado') && $task->estado) {
                $deviceMaintenance = $task->deviceMaintenance;

                if ($deviceMaintenance) {
                    $deviceMaintenance->updateEstadoActual(excludeTaskId: $task->id);
                }
            }
        });
    }

    // Agregar un método en MaintenanceTask.php para facilitar la lógica:
    public function markAsFinalized()
    {
        $this->update(['estado' => true]);
    }
}
