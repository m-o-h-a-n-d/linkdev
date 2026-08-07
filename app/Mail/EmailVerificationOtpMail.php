<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerificationOtpMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public string $otp, public int $expiresInMinutes = 10) {}

    public function build()
    {
        return $this->subject('تأكيد البريد الإلكتروني الخاص بك — Handball Hub')
            ->view('emails.verify-email-otp', [
                'otp' => $this->otp,
                'expiresInMinutes' => $this->expiresInMinutes,
            ]);
    }
}
