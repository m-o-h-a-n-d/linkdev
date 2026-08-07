<?php

namespace App\Notifications;

use App\Mail\OtpMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Notification;

class SendOtpNotify extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public string $otp) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): Mailable
    {
        return (new OtpMail($this->otp))->to($notifiable->email);
    }
}
