<?php

namespace App\Mail;

use App\Models\GameMatch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MatchLiveNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public GameMatch $match
    ) {}

    public function envelope(): Envelope
    {
        $home = $this->match->homeTeam->name ?? 'Home Team';
        $away = $this->match->awayTeam->name ?? 'Away Team';
        $comp = $this->match->competition->name ?? 'Handball Competition';

        return new Envelope(
            subject: "🤾‍♂️ LIVE NOW: {$home} vs {$away} — {$comp}"
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.match-live',
        );
    }
}
