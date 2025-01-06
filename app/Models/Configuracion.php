<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{

    protected $table = 'configuracion';

    protected $fillable = [
        'logo',
        'favicon',
        'nombre',
        'telefono',
        'documento',
        'direccion',
        'correo',
        'implementacion_drive_config',
        'notificacion_vencimiento_hora_ejecucion',
        'notificacion_vencimiento_dias_previos',
        'notificacion_vencimiento_dias_posteriores',
        'notificacion_vencimiento_mensaje',
        'notificacion_actividades_hora_ejecucion',
        'notificacion_actividades_dias_previos'
    ];
}
