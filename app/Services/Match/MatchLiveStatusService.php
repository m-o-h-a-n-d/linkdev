<?php

namespace App\Services\Match;

use App\Models\GameMatch;
use App\Repositories\Contracts\Match\MatchRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class MatchLiveStatusService
{
    public function __construct(
        protected MatchRepositoryInterface $matchRepository
    ) {}

    /**
     * Check all scheduled matches and update them to 'live' if their scheduled time has arrived.
     */
    public function checkAndUpdateLiveStatuses(): Collection
    {
        $now = Carbon::now();

        // Get matches that are 'scheduled' and scheduled_at <= now via repository
        $matchesToLive = $this->matchRepository->getScheduledMatchesToLive($now);

        foreach ($matchesToLive as $match) {
            $this->matchRepository->update($match, [
                'status' => 'live',
                'started_at' => $match->started_at ?? $match->scheduled_at ?? $now,
            ]);

            $this->sendLiveNotification($match);
        }

        return $matchesToLive;
    }

    /**
     * Dispatch live email notification job to queue.
     */
    public function sendLiveNotification(GameMatch $match): void
    {
        try {
            \App\Jobs\SendMatchLiveNotificationJob::dispatch($match);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Live match notification dispatch failed: ' . $e->getMessage());
        }
    }

    /**
     * Calculate elapsed live minutes for a live match.
     */
    public function getElapsedMinutes(GameMatch $match): int
    {
        if ($match->status !== 'live' || ! $match->started_at) {
            return 0;
        }

        $elapsed = (int) Carbon::now()->diffInMinutes($match->started_at);

        // Standard Handball match length is 60 minutes
        return min($elapsed, 60);
    }
}
