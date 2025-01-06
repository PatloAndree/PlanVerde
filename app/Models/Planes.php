<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planes extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_mensual',
        'precio_anual',
        'status'
    ];

    public function pagos()
    {
        return $this->hasMany(Pagos::class);
    }

}
