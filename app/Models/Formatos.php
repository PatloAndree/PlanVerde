<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formatos extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'titulo',
        'contenido',
        'fecha_inicio',
        'status'
    ];

}
