<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\EncuestaClientes;
use Illuminate\Http\Request;
use App\Models\Tickets;
use App\Models\Foros;
use App\Models\RespuestaForos;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class HistorialController extends Controller
{
    public function show()
    {
        $data['titulo'] = 'Historial';
        return view('clientes.historial', $data);
    }
    
}