<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailMessage;
    public $subject;
    public $codeRandom;
    
    /**
     * Create a new message instance.
     *
     * @param string $message
     * @param string $subject
     */
    public function __construct($message, $subject,$codeRandom)
    {
        $this->mailMessage = $message;
        $this->subject = $subject;
        $this->codeRandom = $codeRandom;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('dany.nay.2000@gmail.com','Programming Fields'),
            replyTo:[
                new Address('dany.nay@student.passerellesnumeriques.org','Programming Fields')
            ],
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
    //         view: 'welcome-mail',
    //         with: ['Message' => $this->message],
    //     );
    // }

    public function build()
    {
        return $this->view('mail-template.welcome-mail');
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
