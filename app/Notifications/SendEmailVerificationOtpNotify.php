<?php

namespace App\Notifications;

use App\Mail\EmailVerificationOtpMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Notification;

class SendEmailVerificationOtpNotify extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public string $otp) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): Mailable
    {
        return (new EmailVerificationOtpMail($this->otp))->to($notifiable->email);
    }
}
