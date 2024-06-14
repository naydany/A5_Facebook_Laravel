<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $MailMessage;
    public $subject;
    
    /**
     * Create a new message instance.
     *
     * @param string $message
     * @param string $subject
     */
    public function __construct($message, $subject)
    {
        $this->MailMessage = $message;
        $this->subject = $subject;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'mail-template.welcome-mail',
    //         with: ['MailMessage' => $this->MailMessage],
    //     );
    // }

    public function build()
    {
        return $this->subject('Welcome to Our Service')
                    ->view('mail-template.welcome-mail')
                    ->with(['MailMessage' => $this->MailMessage]);
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
