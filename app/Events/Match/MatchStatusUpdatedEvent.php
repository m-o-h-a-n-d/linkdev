<?php

namespace App\Events\Match;

use App\Models\GameMatch;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MatchStatusUpdatedEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $matchId;
    public string $status;
    public int $homeScore;
    public int $awayScore;
    public ?int $winnerTeamId;
    public string $formattedTimer;

    public function __construct(GameMatch $match)
    {
        $this->matchId = $match->id;
        $this->status = (string) $match->status;
        $this->homeScore = (int) $match->home_score;
        $this->awayScore = (int) $match->away_score;
        $this->winnerTeamId = $match->winner_team_id;
        $this->formattedTimer = $match->formatted_timer;
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
        return 'MatchStatusUpdated';
    }

    public function broadcastWith(): array
    {
        return [
            'match_id' => $this->matchId,
            'status' => $this->status,
            'home_score' => $this->homeScore,
            'away_score' => $this->awayScore,
            'winner_team_id' => $this->winnerTeamId,
            'formatted_timer' => $this->formattedTimer,
        ];
    }
}
