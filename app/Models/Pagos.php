<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagos extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'user_id',
        'plan_id',
        'tipo_pago',
        'plan_nombre',
        'plan_descripcion',
        'fecha_inicio',
        'fecha_fin',
        'fecha_pago',
        'monto',
        'status' // 1 pagado || 2 pendiente
    ];

    protected $casts = [
        'fecha_inicio'  => 'date:d/m/Y',
        'fecha_fin' => 'date:d/m/Y',
        'fecha_pago' => 'datetime:d/m/Y H:m'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresas::class, 'empresa_id');
    }

    public function cliente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function plan()
    {
        return $this->belongsTo(Planes::class);
    }
}
