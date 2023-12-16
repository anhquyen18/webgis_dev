<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $myEmail;
    public $verifyCode;
    public function __construct($myEmail, $verifyCode)
    {
        $this->myEmail = $myEmail;
        $this->verifyCode = $verifyCode;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verification Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.verificationEmail',
            with: ['myEmail' => $this->myEmail, 'verifyCode' => $this->verifyCode],
        );
    }
    // public function build()
    // {
    //     return $this->view('email.verificationEmail');
    // }

    // public function content()
    // {
    //     return view('email.verificationEmail')->render();
    // }
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
