<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Facades\Log;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ActividadesMail extends Mailable
{
    use Queueable, SerializesModels;

    public $actividades;

    /**
     * Create a new message instance.
     */
    public function __construct($actividades)
    {
        $this->actividades = $actividades;
    }


    public function build()
    {
        return $this->subject('Actividades Próximas')
                    ->view('emails.notificaciones_view'); // Asegúrate de crear esta vista
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Actividades Plan verde',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.notificaciones_view',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
