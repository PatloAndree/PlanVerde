<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foros extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'titulo', 'descripcion', 'fecha_cierre', 'status'];

    public function respuestas()
    {
        return $this->hasMany(RespuestaForos::class, 'foro_id');
    }

    // Modelo RespuestaForo
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
