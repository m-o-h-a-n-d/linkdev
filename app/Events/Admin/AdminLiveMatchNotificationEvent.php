<?php

namespace App\Events\Admin;

use App\Models\GameMatch;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdminLiveMatchNotificationEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $notification;

    public function __construct(GameMatch $match)
    {
        $match->loadMissing(['homeTeam', 'awayTeam', 'competition']);

        $homeName = $match->homeTeam?->name ?? 'Home Team';
        $awayName = $match->awayTeam?->name ?? 'Away Team';
        $compName = $match->competition?->name ?? 'Handball Competition';

        $this->notification = [
            'id' => 'match_live_' . $match->id . '_' . time(),
            'type' => 'match.live',
            'title' => '⚡ Match is NOW LIVE!',
            'message' => "{$homeName} vs {$awayName} has just kicked off ({$compName}).",
            'match_id' => $match->id,
            'home_team' => $homeName,
            'away_team' => $awayName,
            'home_score' => (int) $match->home_score,
            'away_score' => (int) $match->away_score,
            'competition' => $compName,
            'url' => route('admin.matches.show', $match->id),
            'live_center_url' => route('admin.matches.live-center'),
            'icon' => 'fas fa-broadcast-tower',
            'created_at' => now()->diffForHumans(),
            'timestamp' => now()->toIso8601String(),
        ];
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('admin-notifications'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'AdminLiveMatchNotification';
    }

    public function broadcastWith(): array
    {
        return [
            'notification' => $this->notification,
        ];
    }
}
