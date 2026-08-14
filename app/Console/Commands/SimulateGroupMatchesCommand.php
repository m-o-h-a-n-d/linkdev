<?php

namespace App\Console\Commands;

use App\Models\Competition;
use App\Models\GameMatch;
use App\Services\Match\FixtureGeneratorService;
use App\Services\Match\MatchStandingsService;
use Illuminate\Console\Command;

class SimulateGroupMatchesCommand extends Command
{
    protected $signature = 'matches:simulate-groups {competition_id?}';
    protected $description = 'Simulate and finish all group stage matches to auto-generate semi-finals.';

    public function handle(FixtureGeneratorService $fixtureService, MatchStandingsService $standingsService): int
    {
        $compId = $this->argument('competition_id');
        $competition = $compId ? Competition::find($compId) : Competition::where('name', 'like', '%المحترفين%')->first() ?? Competition::first();

        if (! $competition) {
            $this->error('No competition found.');
            return Command::FAILURE;
        }

        $this->info("Simulating group stage for: {$competition->name}");

        $groups = $competition->groups;

        foreach ($groups as $group) {
            $existingMatches = GameMatch::where('group_id', $group->id)->get();

            // Generate fixtures if not generated
            if ($existingMatches->isEmpty()) {
                $this->info("Generating fixtures for {$group->name}...");
                $existingMatches = $fixtureService->generateGroupFixtures($group);
            }

            // Simulate realistic scores and finish each match
            foreach ($existingMatches as $match) {
                if ($match->status !== 'finished') {
                    $homeScore = rand(24, 34);
                    $awayScore = rand(22, 33);
                    if ($homeScore === $awayScore) {
                        $homeScore += 1; // Avoid draw for decisive standings
                    }

                    $winnerId = $homeScore > $awayScore ? $match->home_team_id : $match->away_team_id;

                    $match->update([
                        'status' => 'finished',
                        'home_score' => $homeScore,
                        'away_score' => $awayScore,
                        'winner_team_id' => $winnerId,
                        'started_at' => $match->scheduled_at ?? now(),
                        'ended_at' => ($match->scheduled_at ?? now())->copy()->addMinutes(60),
                    ]);
                }
            }

            $standingsService->recalculateGroupStandings($group);
            $this->info("Group {$group->name} standings updated.");
        }

        $standingsService->recalculateTeamStatistics($competition);

        // Auto-generate Semi-Finals
        $standingsService->checkAndGenerateKnockoutFromGroups($competition);
        $standingsService->syncCompetitionDatesAndStatus($competition);

        $semiMatches = GameMatch::where('competition_id', $competition->id)
            ->whereNull('group_id')
            ->with(['homeTeam', 'awayTeam'])
            ->get();

        $this->newLine();
        $this->info("==========================================");
        $this->info(" Group Stage Completed! Semi-Finals Created:");
        $this->info("==========================================");

        foreach ($semiMatches as $index => $semi) {
            $this->line("  [Semi-Final " . ($index + 1) . "] {$semi->homeTeam?->name} vs {$semi->awayTeam?->name} (Scheduled: {$semi->scheduled_at})");
        }

        $this->newLine();
        $this->info("Check your browser now to see the Semi-Finals in Matches and Standings!");

        return Command::SUCCESS;
    }
}
