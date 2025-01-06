<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CreateBusiness extends Mailable
{
    use Queueable, SerializesModels;

    public $empresa;
    public $fechaInicio;
    public $fechaFin;
    public $password;
    public $usuario;
    /**
     * Create a new message instance.
     */
    public function __construct($empresa, $fechaInicio, $fechaFin, $password, $usuario)
    {
        $this->empresa = $empresa;
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->password = $password;
        $this->usuario = $usuario;
    }

    public function build()
    {
        return $this->subject('Bienvenido a nuestra plataforma')
                    ->view('emails.welcome'); // Asegúrate de crear la vista
    }
}
