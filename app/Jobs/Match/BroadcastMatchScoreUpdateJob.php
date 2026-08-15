<?php

namespace App\Jobs\Match;

use App\Events\Match\MatchScoreUpdatedEvent;
use App\Models\GameMatch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class BroadcastMatchScoreUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 2;

    public function __construct(
        public GameMatch $match,
        public string $action
    ) {}

    public function handle(): void
    {
        try {
            event(new MatchScoreUpdatedEvent($this->match, $this->action));
        } catch (\Throwable $e) {
            Log::error('BroadcastMatchScoreUpdateJob failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
