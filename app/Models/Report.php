<?php

namespace App\Models;

use App\Models\Maintenance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;

    protected $table = 'reports';

    protected $fillable = [
        'id_mantenimiento',
        'url_pdf',
        'accion_realizada',
    ];

    public function maintenance()
    {
        return $this->belongsTo(Maintenance::class);
    }
}
