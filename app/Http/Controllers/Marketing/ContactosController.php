<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\EncuestaClientes;
use Illuminate\Http\Request;
use App\Models\Tickets;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class ContactosController extends Controller
{
    public function show()
    {
        $data['titulo'] = 'Contactos';
        return view('marketing.contactos', $data);
    }
}