<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActividadesFotos extends Model
{
    use HasFactory;

    protected $table = 'fotos_actividades';


    protected $fillable = [
        'actividad_id',
        'file_path',
        'status'
    ];

    public function actividades()
    {
        return $this->belongsTo(Actividades::class, 'actividad_id');
    }
    
}
