<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespuestaForos extends Model
{
    use HasFactory;

    protected $table = 'respuesta_foro';

    protected $fillable = [
        'id',
        'user_id',
        'foro_id',
        'mensaje',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
