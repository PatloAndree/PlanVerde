<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'user_id',
        'document_id',
        'document_number',
        'direccion',
        'telefono',
        'email',
        'status' // 1 Activo || 0 Eliminado || 2 Bloqueado
    ];

    public function documento()
    {
        return $this->belongsTo(Documents::class, 'document_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pagos()
    {
        return $this->hasMany(Pagos::class, 'empresa_id');
    }

    public function ultimoPago()
    {
        return $this->hasOne(Pagos::class, 'empresa_id')->latest('id');
    }
}
