<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividades extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'empresa_id',
        'titulo',
        'tipo',
        'descripcion',
        'fecha_inicio',
        'fecha_final',
        'sw_notificado',
        'status'
    ];

    public function ActividadesFotos()
    {
        return $this->hasMany(ActividadesFotos::class, 'actividad_id');
    }

}
