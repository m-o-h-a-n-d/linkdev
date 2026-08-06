<?php

namespace App\DTOs\GameMatch;

use Illuminate\Http\Request;

readonly class CreateMatchData
{
    public function __construct(
        public int $competition_id,
        public int $home_team_id,
        public int $away_team_id,
        public string $scheduled_at,
        public int $round_number,
        public ?int $group_id = null,
        public ?string $status = 'scheduled',
        public ?string $notes = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            competition_id: (int) $request->validated('competition_id'),
            home_team_id: (int) $request->validated('home_team_id'),
            away_team_id: (int) $request->validated('away_team_id'),
            scheduled_at: $request->validated('scheduled_at'),
            round_number: (int) $request->validated('round_number'),
            group_id: $request->validated('group_id') ? (int) $request->validated('group_id') : null,
            status: $request->validated('status', 'scheduled'),
            notes: $request->validated('notes'),
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            competition_id: (int) $data['competition_id'],
            home_team_id: (int) $data['home_team_id'],
            away_team_id: (int) $data['away_team_id'],
            scheduled_at: $data['scheduled_at'],
            round_number: (int) $data['round_number'],
            group_id: isset($data['group_id']) ? (int) $data['group_id'] : null,
            status: $data['status'] ?? 'scheduled',
            notes: $data['notes'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'competition_id' => $this->competition_id,
            'group_id' => $this->group_id,
            'home_team_id' => $this->home_team_id,
            'away_team_id' => $this->away_team_id,
            'scheduled_at' => $this->scheduled_at,
            'round_number' => $this->round_number,
            'status' => $this->status,
            'notes' => $this->notes,
        ], fn ($value) => $value !== null);
    }
}
