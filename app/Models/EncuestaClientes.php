<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EncuestaClientes extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'empresa_id',
        'user_id',
        'encuesta_id',
        'encuesta_preguntas',
        'encuesta_respuestas',
        'notificado',
        'status'
    ];

    protected $casts = [
        'created_at'  => 'datetime:d/m/Y H:m'
    ];

    public function encuesta(){
        return $this->belongsTo(Encuestas::class, 'encuesta_id');
    }
}
