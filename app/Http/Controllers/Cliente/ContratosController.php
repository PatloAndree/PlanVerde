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

class ContratosController extends Controller
{
    public function show()
    {
        $data['titulo'] = 'Contratos';
        return view('clientes.contratos', $data);
    }
    
}