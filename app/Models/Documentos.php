<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentos extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'empresa_id',
        'nombre',
        'ruta',
        'extension',
        'tipo',
        'file_id',
        'status'
    ];
    protected $casts = [
        'created_at'  => 'datetime:d/m/Y H:m'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresas::class, 'empresa_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
