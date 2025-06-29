<?php

namespace App\Models;

use App\Models\Maintenance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Entity extends Model
{
    use HasFactory;
    protected $table = 'entities';

    protected $fillable = [
        'tipo_entidad',
        'identificacion_entidad',
        'nombre_entidad',
        'telefono_entidad',
        'direccion_entidad',
        'referencia_direccion_entidad',
        'tipo_identificacion_entidad',
        'id_entidad_padre',
    ];

    public function cliente()
    {
        return $this->belongsTo(Entity::class, 'id_entidad_padre');
    }

    public function empresa()
    {
        return $this->hasMany(Entity::class, 'id_entidad_padre');
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class, 'id_mantenimiento');
    }
}

