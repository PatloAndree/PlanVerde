<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoSoporte extends Model
{
    use HasFactory;

    protected $table = 'documentos_soportes';
    
    protected $fillable = [
        'user_id',
        'respuesta_tickets_id',
        'nombre',
        'ruta',
        'extension',
        'tipo',
        'file_id',
        'status'
    ];
   

}
