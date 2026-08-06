<?php

namespace App\DTOs\Competition;

use Illuminate\Http\Request;

readonly class UpdateCompetitionData
{
    public function __construct(
        public ?string $name = null,
        public ?string $slug = null,
        public ?string $description = null,
        public ?string $season = null,
        public ?string $status = null,
        public ?string $start_date = null,
        public ?string $end_date = null,
        public ?int $winner_team_id = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->validated('name'),
            slug: $request->validated('slug'),
            description: $request->validated('description'),
            season: $request->validated('season'),
            status: $request->validated('status'),
            start_date: $request->validated('start_date'),
            end_date: $request->validated('end_date'),
            winner_team_id: $request->validated('winner_team_id') ? (int) $request->validated('winner_team_id') : null,
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            slug: $data['slug'] ?? null,
            description: $data['description'] ?? null,
            season: $data['season'] ?? null,
            status: $data['status'] ?? null,
            start_date: $data['start_date'] ?? null,
            end_date: $data['end_date'] ?? null,
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
            'winner_team_id' => $this->winner_team_id,
        ], fn ($value) => $value !== null);
    }
}
