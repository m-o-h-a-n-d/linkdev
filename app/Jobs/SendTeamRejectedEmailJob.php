<?php

namespace App\Jobs;

use App\Mail\TeamRejectedMail;
use App\Models\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendTeamRejectedEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 5;

    public function __construct(
        public Team $team,
        public ?string $reason = null
    ) {}

    public function handle(): void
    {
        if (! $this->team->email) {
            return;
        }

        try {
            Mail::to($this->team->email)->send(new TeamRejectedMail($this->team, $this->reason));
        } catch (\Throwable $e) {
            Log::error('SendTeamRejectedEmailJob failed for team: ' . $this->team->id . ' - ' . $e->getMessage());
            throw $e;
        }
    }
}
