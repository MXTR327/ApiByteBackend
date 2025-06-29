<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DeviceMaintenance;

class StateHistory extends Model
{
    use HasFactory;

    protected $table = 'state_histories';

    protected $fillable = [
        'id_equipo_mantenimiento',
        'estado',
        'notas_historial',
        'anexo'
    ];

    public function deviceMaintenance()
    {
        return $this->belongsTo(DeviceMaintenance::class, 'id_equipo_mantenimiento');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($stateHistory) {
            // Actualiza el estado_actual en DeviceMaintenance
            $stateHistory->deviceMaintenance->update(['estado_actual' => $stateHistory->estado]);
        });
    }
}
