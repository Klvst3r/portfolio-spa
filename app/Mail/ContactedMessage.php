<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactedMessage extends Mailable
{
    use Queueable, SerializesModels;


    //1. Definimos las propiedades que vamos a recibir del formulario de contacto
    public $name;
    public $email;
    public $message;

    /**
     * Create a new message instance.
     */
    //en el constructor tengo que definir las propiedades que voy a recibir del formulario de contacto
    public function __construct($name, $email, $message)
    {
        //Podremos predefinir los valores para las propiedades, pero lo ideal es que los recibamos del formulario de contacto, redibiendo los valores que se reciben como parametros en el constructor, para luego poder usarlos en la vista del correo electrónico.
        $this->name = $name;
        $this->email = $email;
        $this->message = $message;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            // Podemos personalizar el asunto con el nombre de quien escribe
            subject: 'Nuevo mensaje de contacto de: ' . $this->name,
            replyTo: $this->email, // Permite responder directamente al usuario
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            // Aquí es donde definimos la vista, reemplazando al antiguo build()
            markdown: 'mail.contacted-message',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        // ... attachments queda igual
        return [];
    }
}
