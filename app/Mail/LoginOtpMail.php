<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class LoginOtpMail extends Mailable
{
    public $otp;
    public $user;

    public function __construct($user, $otp)
    {
        $this->user = $user;
        $this->otp  = $otp;
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Kode OTP Login - Polres Gunungkidul');
    }

    public function content(): Content
    {
        return new Content(markdown: 'emails.admin.otp');
    }
}