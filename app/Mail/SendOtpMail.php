<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $otp,
        public int $expiresInMinutes = 10
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Password Reset Verification Code (OTP)',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.otp-email',
            with: [
                'otp' => $this->otp,
                'expiresInMinutes' => $this->expiresInMinutes,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
