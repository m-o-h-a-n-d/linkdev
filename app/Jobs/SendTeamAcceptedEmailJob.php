<?php

namespace App\Jobs;

use App\Mail\TeamAcceptedMail;
use App\Models\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendTeamAcceptedEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 5;

    public function __construct(
        public Team $team
    ) {}

    public function handle(): void
    {
        if (! $this->team->email) {
            return;
        }

        try {
            Mail::to($this->team->email)->send(new TeamAcceptedMail($this->team));
        } catch (\Throwable $e) {
            Log::error('SendTeamAcceptedEmailJob failed for team: ' . $this->team->id . ' - ' . $e->getMessage());
            throw $e;
        }
    }
}
