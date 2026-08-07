<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public string $otp, public int $expiresInMinutes = 10) {}

    public function build()
    {
        return $this->subject('HandBall - Your One-Time Password (OTP) Verification Code')
            ->view('emails.otp', [
                'otp' => $this->otp,
                'expiresInMinutes' => $this->expiresInMinutes,
            ]);
    }
}
