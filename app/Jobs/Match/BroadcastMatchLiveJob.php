<?php

namespace App\Jobs\Match;

use App\Events\Admin\AdminLiveMatchNotificationEvent;
use App\Events\Match\MatchStartedLiveEvent;
use App\Models\GameMatch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class BroadcastMatchLiveJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 2;

    public function __construct(
        public GameMatch $match
    ) {}

    public function handle(): void
    {
        try {
            $this->match->loadMissing(['competition', 'group', 'homeTeam', 'awayTeam']);

            // Broadcast real-time match to live screens
            event(new MatchStartedLiveEvent($this->match));

            // Broadcast real-time notification to all admins
            event(new AdminLiveMatchNotificationEvent($this->match));
        } catch (\Throwable $e) {
            Log::error('BroadcastMatchLiveJob failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
