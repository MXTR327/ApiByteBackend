<?php

namespace App\Models;

use App\Models\DeviceType;
use App\Models\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brands extends Model
{
    use HasFactory;
    protected $table = 'brands';
    protected $fillable = [
        'nombre_marca',
        'id_tipo_dispositivo',
    ];

    public function deviceType()
    {
        return $this->belongsTo(DeviceType::class, 'id_tipo_dispositivo');
    }

    public function models()
    {
        return $this->hasMany(Models::class, 'id_marca');
    }
}
