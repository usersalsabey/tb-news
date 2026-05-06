<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminCredentialsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;
    public $verifyUrl;

    public function __construct($user, $password, $verifyUrl)
    {
        $this->user      = $user;
        $this->password  = $password;
        $this->verifyUrl = $verifyUrl;
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Kredensial Akun Admin - Polres Gunungkidul');
    }

    public function content(): Content
    {
        return new Content(markdown: 'emails.admin.credentials');
    }
}