<?php

namespace App\Jobs\Match;

use App\Events\Match\MatchStatusUpdatedEvent;
use App\Models\GameMatch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class BroadcastMatchStatusJob implements ShouldQueue
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
            event(new MatchStatusUpdatedEvent($this->match));
        } catch (\Throwable $e) {
            Log::error('BroadcastMatchStatusJob failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
