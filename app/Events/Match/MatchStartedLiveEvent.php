<?php

namespace App\Events\Match;

use App\Models\GameMatch;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MatchStartedLiveEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $matchData;

    public function __construct(GameMatch $match)
    {
        $match->loadMissing(['homeTeam', 'awayTeam', 'competition', 'group']);

        $this->matchData = [
            'id' => $match->id,
            'competition_id' => $match->competition_id,
            'competition_name' => $match->competition?->name ?? 'Competition',
            'group_name' => $match->group?->name ?? ('Round ' . $match->round_number),
            'round_number' => $match->round_number,
            'home_team_id' => $match->home_team_id,
            'home_team_name' => $match->homeTeam?->name ?? 'Home Team',
            'away_team_id' => $match->away_team_id,
            'away_team_name' => $match->awayTeam?->name ?? 'Away Team',
            'home_score' => (int) $match->home_score,
            'away_score' => (int) $match->away_score,
            'status' => 'live',
            'started_at' => $match->started_at?->toIso8601String() ?? now()->toIso8601String(),
            'formatted_timer' => $match->formatted_timer,
        ];
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('live-matches'),
            new Channel('matches'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'MatchStartedLive';
    }

    public function broadcastWith(): array
    {
        return [
            'match' => $this->matchData,
        ];
    }
}
