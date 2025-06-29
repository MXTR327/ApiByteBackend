<?php

namespace App\Models;

use App\Models\Brands;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeviceType extends Model
{
    use HasFactory;
    protected $table = 'device_types';
    protected $fillable = [
        'tipo_dispositivo'
    ];

    public function brands()
    {
        return $this->hasMany(Brands::class, 'id_tipo_dispositivo');
    }
}
