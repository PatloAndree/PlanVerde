<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorsControllers extends Controller
{
    public function notpayment(){
        $data['title']='Falta de pago';
        return view('errors.bloqueo',$data);
    }
}
