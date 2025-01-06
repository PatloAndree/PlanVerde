<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encuestas extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'titulo',
        'descripcion',
        'contenido',
        'fecha_inicio',
        'status'
    ];

}
