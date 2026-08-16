<?php

namespace Tests\Feature;

use App\Models\Competition;
use App\Models\CompetitionGroup;
use App\Models\CompetitionSetting;
use App\Models\GameMatch;
use App\Models\Team;
use App\Models\User;
use App\Services\Match\MatchService;
use App\Services\Match\MatchStandingsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KnockoutStageTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Competition $competition;
    protected CompetitionGroup $groupA;
    protected CompetitionGroup $groupB;
    protected Team $teamA1;
    protected Team $teamA2;
    protected Team $teamB1;
    protected Team $teamB2;

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
            'name' => 'Cup 2026',
            'description' => 'Test knockout cup',
            'season' => '2026',
            'status' => 'ongoing',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addDays(14)->toDateString(),
            'created_by_user_id' => $this->user->id,
        ]);

        CompetitionSetting::create([
            'competition_id' => $this->competition->id,
            'competition_type' => 'mixed',
            'max_teams' => 4,
            'points_win' => 3,
            'points_draw' => 1,
            'points_loss' => 0,
        ]);

        $this->groupA = CompetitionGroup::create([
            'competition_id' => $this->competition->id,
            'name' => 'Group A',
        ]);

        $this->groupB = CompetitionGroup::create([
            'competition_id' => $this->competition->id,
            'name' => 'Group B',
        ]);

        $this->teamA1 = Team::create(['name' => 'Team A1', 'short_name' => 'A1', 'logo' => 'teams/a1.png', 'city' => 'Cairo', 'country' => 'Egypt']);
        $this->teamA2 = Team::create(['name' => 'Team A2', 'short_name' => 'A2', 'logo' => 'teams/a2.png', 'city' => 'Cairo', 'country' => 'Egypt']);
        $this->teamB1 = Team::create(['name' => 'Team B1', 'short_name' => 'B1', 'logo' => 'teams/b1.png', 'city' => 'Giza', 'country' => 'Egypt']);
        $this->teamB2 = Team::create(['name' => 'Team B2', 'short_name' => 'B2', 'logo' => 'teams/b2.png', 'city' => 'Giza', 'country' => 'Egypt']);

        $this->competition->teams()->attach([$this->teamA1->id, $this->teamA2->id, $this->teamB1->id, $this->teamB2->id]);
        $this->groupA->teams()->attach([$this->teamA1->id, $this->teamA2->id]);
        $this->groupB->teams()->attach([$this->teamB1->id, $this->teamB2->id]);
    }

    public function test_knockout_generation_and_progression(): void
    {
        /** @var MatchStandingsService $standingsService */
        $standingsService = app(MatchStandingsService::class);
        /** @var MatchService $matchService */
        $matchService = app(MatchService::class);

        // 1. Group A match: A1 beats A2
        $matchGA = GameMatch::create([
            'competition_id' => $this->competition->id,
            'group_id' => $this->groupA->id,
            'home_team_id' => $this->teamA1->id,
            'away_team_id' => $this->teamA2->id,
            'winner_team_id' => $this->teamA1->id,
            'scheduled_at' => now()->subDays(3),
            'status' => 'finished',
            'home_score' => 2,
            'away_score' => 0,
            'round_number' => 1,
        ]);

        // 2. Group B match: B1 beats B2
        $matchGB = GameMatch::create([
            'competition_id' => $this->competition->id,
            'group_id' => $this->groupB->id,
            'home_team_id' => $this->teamB1->id,
            'away_team_id' => $this->teamB2->id,
            'winner_team_id' => $this->teamB1->id,
            'scheduled_at' => now()->subDays(3),
            'status' => 'finished',
            'home_score' => 3,
            'away_score' => 1,
            'round_number' => 1,
        ]);

        // Recalculate standings for both groups
        $standingsService->recalculateGroupStandings($this->groupA);
        $standingsService->recalculateGroupStandings($this->groupB);

        // Check and generate semi-finals
        $standingsService->checkAndGenerateKnockoutFromGroups($this->competition);

        $semiMatches = GameMatch::where('competition_id', $this->competition->id)
            ->whereNull('group_id')
            ->get();

        $this->assertCount(2, $semiMatches);

        $semi1 = $semiMatches->firstWhere('home_team_id', $this->teamA1->id);
        $this->assertNotNull($semi1);
        $this->assertEquals($this->teamB2->id, $semi1->away_team_id);

        $semi2 = $semiMatches->firstWhere('home_team_id', $this->teamB1->id);
        $this->assertNotNull($semi2);
        $this->assertEquals($this->teamA2->id, $semi2->away_team_id);

        // 3. Finish Semi 1: A1 wins
        $semi1->update([
            'status' => 'finished',
            'home_score' => 1,
            'away_score' => 0,
            'winner_team_id' => $this->teamA1->id,
        ]);
        $standingsService->advanceKnockoutWinner($semi1);

        // Final shouldn't be generated yet because Semi 2 is still pending
        $finalMatch = GameMatch::where('competition_id', $this->competition->id)
            ->whereNull('group_id')
            ->where('round_number', $semi1->round_number + 1)
            ->first();
        $this->assertNull($finalMatch);

        // 4. Finish Semi 2: B1 wins
        $semi2->update([
            'status' => 'finished',
            'home_score' => 2,
            'away_score' => 1,
            'winner_team_id' => $this->teamB1->id,
        ]);
        $standingsService->advanceKnockoutWinner($semi2);

        // Final match should now be created!
        $finalMatch = GameMatch::where('competition_id', $this->competition->id)
            ->whereNull('group_id')
            ->where('round_number', $semi1->round_number + 1)
            ->first();

        $this->assertNotNull($finalMatch);
        $this->assertEquals($this->teamA1->id, $finalMatch->home_team_id);
        $this->assertEquals($this->teamB1->id, $finalMatch->away_team_id);

        // 5. Finish Final: A1 wins on penalties (score tied 2-2, winner assigned to A1)
        $finalMatch->update([
            'status' => 'finished',
            'home_score' => 2,
            'away_score' => 2,
            'winner_team_id' => $this->teamA1->id,
        ]);
        $standingsService->advanceKnockoutWinner($finalMatch);

        $this->competition->refresh();
        $this->assertEquals('completed', $this->competition->status);
        $this->assertEquals($this->teamA1->id, $this->competition->winner_team_id);
    }
}
