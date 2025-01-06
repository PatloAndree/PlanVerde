<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre;
    public $apellidos;
    public $telefono;
    public $email;
    public $password;


    /**
     * Create a new message instance.
     */
    public function __construct($nombre, $apellidos, $telefono, $email, $password)
    {
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Bienvenido a nuestra plataforma')
                    ->view('emails.newUser'); // Asegúrate de crear la vista
    }
}
