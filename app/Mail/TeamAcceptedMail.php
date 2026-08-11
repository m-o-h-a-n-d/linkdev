<?php

namespace App\Mail;

use App\Models\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeamAcceptedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Team $team) {}

    public function build()
    {
        return $this->subject('تهانينا! تم قبول طلب تسجيل فريقك — Handball Hub')
            ->view('emails.team-accepted', [
                'team' => $this->team,
            ]);
    }
}
