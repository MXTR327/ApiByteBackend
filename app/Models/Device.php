<?php

namespace App\Models;

use App\Models\Brands;
use App\Models\Models;
use App\Models\DeviceType;
use App\Models\DeviceMaintenance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Device extends Model
{
    use HasFactory;

    protected $table = 'devices';

    protected $fillable = [
        'id_tipo_dispositivo',
        'id_marca',
        'id_modelo'
    ];

    public function deviceType()
    {
        return $this->belongsTo(DeviceType::class, 'id_tipo_dispositivo');
    }

    public function brand()
    {
        return $this->belongsTo(Brands::class, 'id_marca');
    }
    public function model()
    {
        return $this->belongsTo(Models::class, 'id_modelo');
    }

    public function devicesMaintenance()
    {
        return $this->hasMany(DeviceMaintenance::class, 'id_equipo_mantenimiento');
    }
}
