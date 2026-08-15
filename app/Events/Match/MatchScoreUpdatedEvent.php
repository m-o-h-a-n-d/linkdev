<?php

namespace App\Events\Match;

use App\Models\GameMatch;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MatchScoreUpdatedEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $matchId;
    public int $homeScore;
    public int $awayScore;
    public string $action;
    public ?string $updatedSide;
    public string $status;
    public string $formattedTimer;

    public function __construct(GameMatch $match, string $action)
    {
        $this->matchId = $match->id;
        $this->homeScore = (int) $match->home_score;
        $this->awayScore = (int) $match->away_score;
        $this->action = $action;
        $this->status = (string) $match->status;
        $this->formattedTimer = $match->formatted_timer;

        $this->updatedSide = match ($action) {
            'increment_home', 'decrement_home' => 'home',
            'increment_away', 'decrement_away' => 'away',
            default => null,
        };
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('live-matches'),
            new Channel('match.' . $this->matchId),
        ];
    }

    public function broadcastAs(): string
    {
        return 'MatchScoreUpdated';
    }

    public function broadcastWith(): array
    {
        return [
            'match_id' => $this->matchId,
            'home_score' => $this->homeScore,
            'away_score' => $this->awayScore,
            'action' => $this->action,
            'updated_side' => $this->updatedSide,
            'status' => $this->status,
            'formatted_timer' => $this->formattedTimer,
        ];
    }
}
