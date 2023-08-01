<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PostMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $adminEmail;

    /**
     * Create a new message instance.
     */
    public function __construct($data, $adminEmail)
    {
        $this->data = $data;
        $this->adminEmail = $adminEmail;
    }

    public function build()
    {
        return $this->subject('Data Form')
                    ->markdown('emails.post');
    }

    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Post Mail',
    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    // /**
    //  * Get the attachments for the message.
    //  *
    //  * @return array<int, \Illuminate\Mail\Mailables\Attachment>
    //  */
    // public function attachments(): array
    // {
    //     return [];
    // }
}
