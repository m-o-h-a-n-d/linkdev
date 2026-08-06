<?php

namespace App\DTOs\GameMatch;

use Illuminate\Http\Request;

readonly class UpdateMatchData
{
    public function __construct(
        public ?string $status = null,
        public ?string $started_at = null,
        public ?string $ended_at = null,
        public ?int $home_score = null,
        public ?int $away_score = null,
        public ?int $winner_team_id = null,
        public ?string $notes = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            status: $request->validated('status'),
            started_at: $request->validated('started_at'),
            ended_at: $request->validated('ended_at'),
            home_score: $request->validated('home_score') !== null ? (int) $request->validated('home_score') : null,
            away_score: $request->validated('away_score') !== null ? (int) $request->validated('away_score') : null,
            winner_team_id: $request->validated('winner_team_id') ? (int) $request->validated('winner_team_id') : null,
            notes: $request->validated('notes'),
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            status: $data['status'] ?? null,
            started_at: $data['started_at'] ?? null,
            ended_at: $data['ended_at'] ?? null,
            home_score: isset($data['home_score']) ? (int) $data['home_score'] : null,
            away_score: isset($data['away_score']) ? (int) $data['away_score'] : null,
            winner_team_id: isset($data['winner_team_id']) ? (int) $data['winner_team_id'] : null,
            notes: $data['notes'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'status' => $this->status,
            'started_at' => $this->started_at,
            'ended_at' => $this->ended_at,
            'home_score' => $this->home_score,
            'away_score' => $this->away_score,
            'winner_team_id' => $this->winner_team_id,
            'notes' => $this->notes,
        ], fn ($value) => $value !== null);
    }
}
