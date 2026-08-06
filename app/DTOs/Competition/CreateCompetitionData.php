<?php

namespace App\DTOs\Competition;

use Illuminate\Http\Request;

readonly class CreateCompetitionData
{
    public function __construct(
        public string $name,
        public string $slug,
        public string $description,
        public string $season,
        public string $status,
        public string $start_date,
        public string $end_date,
        public int $created_by_user_id,
        public ?int $winner_team_id = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->validated('name'),
            slug: $request->validated('slug'),
            description: $request->validated('description'),
            season: $request->validated('season'),
            status: $request->validated('status', 'draft'),
            start_date: $request->validated('start_date'),
            end_date: $request->validated('end_date'),
            created_by_user_id: (int) $request->validated('created_by_user_id'),
            winner_team_id: $request->validated('winner_team_id') ? (int) $request->validated('winner_team_id') : null,
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            slug: $data['slug'],
            description: $data['description'],
            season: $data['season'],
            status: $data['status'] ?? 'draft',
            start_date: $data['start_date'],
            end_date: $data['end_date'],
            created_by_user_id: (int) $data['created_by_user_id'],
            winner_team_id: isset($data['winner_team_id']) ? (int) $data['winner_team_id'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'season' => $this->season,
            'status' => $this->status,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'created_by_user_id' => $this->created_by_user_id,
            'winner_team_id' => $this->winner_team_id,
        ], fn ($value) => $value !== null);
    }
}
