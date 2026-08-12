<?php

namespace App\Mail;

use App\Models\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeamRejectedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Team $team,
        public ?string $reason = null
    ) {}

    public function build()
    {
        return $this->subject('تحديث بشأن طلب تسجيل فريقك — Handball Hub')
            ->view('emails.team-rejected', [
                'team' => $this->team,
                'reason' => $this->reason,
            ]);
    }
}
