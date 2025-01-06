<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespuestaTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'ticket_id',
        'mensaje',
        'status'
    ];

}
