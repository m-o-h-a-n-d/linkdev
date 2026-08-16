<?php

namespace Tests\Feature;

use App\Models\Competition;
use App\Models\CompetitionGroup;
use App\Models\CompetitionSetting;
use App\Models\GameMatch;
use App\Models\Team;
use App\Models\User;
use App\Services\Match\MatchStandingsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MatchStandingsTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Competition $competition;
    protected CompetitionGroup $group;
    protected Team $teamA;
    protected Team $teamB;
    protected Team $teamC;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);
        $this->actingAs($this->user);

        $this->competition = Competition::create([
            'name' => 'Tournament 2026',
            'description' => 'Test tournament',
            'season' => '2026',
            'status' => 'ongoing',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addDays(14)->toDateString(),
            'created_by_user_id' => $this->user->id,
        ]);

        CompetitionSetting::create([
            'competition_id' => $this->competition->id,
            'competition_type' => 'mixed',
            'max_teams' => 8,
            'points_win' => 3,
            'points_draw' => 1,
            'points_loss' => 0,
        ]);

        $this->group = CompetitionGroup::create([
            'competition_id' => $this->competition->id,
            'name' => 'Group A',
        ]);

        $this->teamA = Team::create(['name' => 'Team Alpha', 'short_name' => 'ALP', 'logo' => 'teams/alpha.png', 'city' => 'Cairo', 'country' => 'Egypt']);
        $this->teamB = Team::create(['name' => 'Team Beta', 'short_name' => 'BET', 'logo' => 'teams/beta.png', 'city' => 'Alexandria', 'country' => 'Egypt']);
        $this->teamC = Team::create(['name' => 'Team Gamma', 'short_name' => 'GAM', 'logo' => 'teams/gamma.png', 'city' => 'Giza', 'country' => 'Egypt']);

        $this->competition->teams()->attach([$this->teamA->id, $this->teamB->id, $this->teamC->id]);
        $this->group->teams()->attach([$this->teamA->id, $this->teamB->id, $this->teamC->id]);
    }

    public function test_group_standings_recalculation_is_idempotent(): void
    {
        // Create finished matches: Team A beats Team B (3 - 1), Team B draws Team C (2 - 2)
        GameMatch::create([
            'competition_id' => $this->competition->id,
            'group_id' => $this->group->id,
            'home_team_id' => $this->teamA->id,
            'away_team_id' => $this->teamB->id,
            'winner_team_id' => $this->teamA->id,
            'scheduled_at' => now()->subDays(2),
            'status' => 'finished',
            'home_score' => 3,
            'away_score' => 1,
            'round_number' => 1,
        ]);

        GameMatch::create([
            'competition_id' => $this->competition->id,
            'group_id' => $this->group->id,
            'home_team_id' => $this->teamB->id,
            'away_team_id' => $this->teamC->id,
            'winner_team_id' => null,
            'scheduled_at' => now()->subDay(),
            'status' => 'finished',
            'home_score' => 2,
            'away_score' => 2,
            'round_number' => 2,
        ]);

        /** @var MatchStandingsService $standingsService */
        $standingsService = app(MatchStandingsService::class);

        // Run calculation once
        $standingsService->recalculateGroupStandings($this->group);

        $teamAStanding = $this->group->standings()->where('team_id', $this->teamA->id)->first();
        $this->assertNotNull($teamAStanding);
        $this->assertEquals(1, $teamAStanding->played);
        $this->assertEquals(1, $teamAStanding->won);
        $this->assertEquals(3, $teamAStanding->points);
        $this->assertEquals(1, $teamAStanding->position_rank);

        $teamBStanding = $this->group->standings()->where('team_id', $this->teamB->id)->first();
        $this->assertEquals(2, $teamBStanding->played);
        $this->assertEquals(0, $teamBStanding->won);
        $this->assertEquals(1, $teamBStanding->draw);
        $this->assertEquals(1, $teamBStanding->lost);
        $this->assertEquals(1, $teamBStanding->points);

        // Run calculation a SECOND and THIRD time (Idempotency test)
        $standingsService->recalculateGroupStandings($this->group);
        $standingsService->recalculateGroupStandings($this->group);

        // Assert points and records did not double
        $teamAStandingRefreshed = $this->group->standings()->where('team_id', $this->teamA->id)->first();
        $this->assertEquals(3, $teamAStandingRefreshed->points);
        $this->assertEquals(1, $teamAStandingRefreshed->played);

        $teamBStandingRefreshed = $this->group->standings()->where('team_id', $this->teamB->id)->first();
        $this->assertEquals(1, $teamBStandingRefreshed->points);
        $this->assertEquals(2, $teamBStandingRefreshed->played);
    }
}
