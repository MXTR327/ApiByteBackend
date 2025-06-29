<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Brands;
use App\Models\Device;
use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    use HasFactory;
    protected $table = 'models';
    protected $fillable = [
        'nombre_modelo',
        'id_marca',
    ];

    public function brand()
    {
        return $this->belongsTo(Brands::class, 'id_marca');
    }

    public function devices()
    {
        return $this->hasMany(Device::class, 'id_modelo');
    }
}
