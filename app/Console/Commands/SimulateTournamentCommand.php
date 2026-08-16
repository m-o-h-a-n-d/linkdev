<?php

namespace App\Console\Commands;

use App\Models\Competition;
use App\Models\GameMatch;
use App\Services\Match\FixtureGeneratorService;
use App\Services\Match\MatchService;
use App\Services\Match\MatchStandingsService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SimulateTournamentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'matches:simulate 
                            {competition_id? : ID of the competition to simulate} 
                            {--mode=all : Simulation mode: all, groups, knockout, reset}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simulate tournament matches (Groups, Knockouts, or Full Tournament until champion crowning)';

    public function handle(
        MatchService $matchService,
        FixtureGeneratorService $fixtureService,
        MatchStandingsService $standingsService
    ): int {
        $compId = $this->argument('competition_id');
        $mode = strtolower($this->option('mode') ?? 'all');

        $competition = $compId
            ? Competition::find($compId)
            : Competition::where('status', '!=', 'completed')->latest()->first() ?? Competition::first();

        if (! $competition) {
            $this->error('❌ No competition found to simulate.');
            return Command::FAILURE;
        }

        $this->info("🏆 Selected Competition: [ID: {$competition->id}] {$competition->name} ({$competition->season})");

        if ($mode === 'reset') {
            return $this->resetTournament($competition, $standingsService);
        }

        if ($mode === 'groups' || $mode === 'all') {
            $this->simulateGroups($competition, $matchService, $fixtureService, $standingsService);
        }

        if ($mode === 'knockout' || $mode === 'all') {
            $this->simulateKnockouts($competition, $standingsService);
        }

        return Command::SUCCESS;
    }

    /**
     * Simulate and finalize all group stage matches.
     */
    protected function simulateGroups(
        Competition $competition,
        MatchService $matchService,
        FixtureGeneratorService $fixtureService,
        MatchStandingsService $standingsService
    ): void {
        $this->newLine();
        $this->line('<fg=yellow;options=bold>==================================================</>');
        $this->line('<fg=yellow;options=bold> 1. SIMULATING GROUP STAGE MATCHES               </>');
        $this->line('<fg=yellow;options=bold>==================================================</>');

        $groups = $competition->groups()->with('teams')->get();

        if ($groups->isEmpty()) {
            $this->warn('⚠️ No groups found in this competition.');
            return;
        }

        foreach ($groups as $group) {
            $this->info("📌 Processing Group: {$group->name} ({$group->teams->count()} teams)");

            $existingMatches = GameMatch::where('group_id', $group->id)->get();

            if ($existingMatches->isEmpty()) {
                $this->line("   Generating fixtures for {$group->name}...");
                $existingMatches = $fixtureService->generateGroupFixtures($group);
            }

            $matchesSimulated = 0;
            foreach ($existingMatches as $match) {
                if ($match->status !== 'finished') {
                    $homeScore = rand(24, 35);
                    $awayScore = rand(22, 34);
                    if ($homeScore === $awayScore && rand(0, 1) === 1) {
                        $homeScore += 1;
                    }

                    $winnerId = null;
                    if ($homeScore > $awayScore) {
                        $winnerId = $match->home_team_id;
                    } elseif ($awayScore > $homeScore) {
                        $winnerId = $match->away_team_id;
                    }

                    $match->update([
                        'status' => 'finished',
                        'home_score' => $homeScore,
                        'away_score' => $awayScore,
                        'winner_team_id' => $winnerId,
                        'started_at' => $match->scheduled_at ?? now(),
                        'ended_at' => ($match->scheduled_at ?? now())->copy()->addMinutes(60),
                    ]);

                    $matchesSimulated++;
                }
            }

            $standingsService->recalculateGroupStandings($group);
            $this->line("   <fg=green>✔ Completed & calculated {$matchesSimulated} matches for {$group->name}.</>");
        }

        $standingsService->recalculateTeamStatistics($competition);
        $standingsService->checkAndGenerateKnockoutFromGroups($competition);
        $standingsService->syncCompetitionDatesAndStatus($competition);

        $this->line('<fg=green;options=bold>✔ Group Stage Completed & Standings Updated Successfully!</>');
    }

    /**
     * Simulate all pending knockout rounds until tournament completion.
     */
    protected function simulateKnockouts(Competition $competition, MatchStandingsService $standingsService): void
    {
        $this->newLine();
        $this->line('<fg=cyan;options=bold>==================================================</>');
        $this->line('<fg=cyan;options=bold> 2. SIMULATING KNOCKOUT STAGE (TOURNAMENT TREE)   </>');
        $this->line('<fg=cyan;options=bold>==================================================</>');

        $maxIterations = 10;
        $iteration = 0;

        while ($iteration < $maxIterations) {
            $iteration++;

            $knockoutMatches = GameMatch::where('competition_id', $competition->id)
                ->whereNull('group_id')
                ->where('status', '!=', 'finished')
                ->with(['homeTeam', 'awayTeam'])
                ->get();

            if ($knockoutMatches->isEmpty()) {
                break;
            }

            $currentRound = $knockoutMatches->first()->round_number;
            $roundMatches = $knockoutMatches->where('round_number', $currentRound);

            $roundName = match ($roundMatches->count()) {
                1 => 'Final Match 🏆',
                2 => 'Semi-Finals ⚔️',
                4 => 'Quarter-Finals 🛡️',
                default => "Knockout Round {$currentRound}",
            };

            $this->info("\n👉 Simulating {$roundName} (Round {$currentRound}):");

            foreach ($roundMatches as $match) {
                $homeScore = rand(25, 34);
                $awayScore = rand(24, 33);
                
                // Knockout matches MUST have a winner
                if ($homeScore === $awayScore) {
                    $homeScore += rand(1, 2);
                }

                $winnerId = $homeScore > $awayScore ? $match->home_team_id : $match->away_team_id;
                $winnerTeam = $homeScore > $awayScore ? $match->homeTeam : $match->awayTeam;

                $match->update([
                    'status' => 'finished',
                    'home_score' => $homeScore,
                    'away_score' => $awayScore,
                    'winner_team_id' => $winnerId,
                    'started_at' => $match->scheduled_at ?? now(),
                    'ended_at' => ($match->scheduled_at ?? now())->copy()->addMinutes(60),
                ]);

                $this->line("   • {$match->homeTeam?->name} <fg=yellow>{$homeScore} - {$awayScore}</> {$match->awayTeam?->name} -> <fg=green;options=bold>Winner: {$winnerTeam?->name}</>");

                // Advance winner
                $standingsService->advanceKnockoutWinner($match);
            }

            $standingsService->syncCompetitionDatesAndStatus($competition);
        }

        $competition->refresh();
        $winner = $competition->winnerTeam;

        $this->newLine();
        $this->line('<fg=yellow;options=bold>==================================================</>');
        if ($winner) {
            $this->line("<fg=yellow;options=bold> 🏆 TOURNAMENT CHAMPION: {$winner->name} ({$winner->short_name}) </fg=yellow;options=bold>");
        }
        $this->line("<fg=green;options=bold> 🏅 Competition Status: {$competition->status} </fg=green;options=bold>");
        $this->line('<fg=yellow;options=bold>==================================================</>');
    }

    /**
     * Reset competition matches & standings back to initial state.
     */
    protected function resetTournament(Competition $competition, MatchStandingsService $standingsService): int
    {
        $this->warn("🔄 Resetting matches & standings for: {$competition->name}");

        DB::transaction(function () use ($competition, $standingsService) {
            // 1. Delete all knockout matches
            GameMatch::where('competition_id', $competition->id)->whereNull('group_id')->delete();

            // 2. Reset group matches to scheduled 0-0
            GameMatch::where('competition_id', $competition->id)->whereNotNull('group_id')->update([
                'status' => 'scheduled',
                'home_score' => 0,
                'away_score' => 0,
                'winner_team_id' => null,
                'started_at' => null,
                'ended_at' => null,
            ]);

            // 3. Reset group standings
            foreach ($competition->groups as $group) {
                $standingsService->recalculateGroupStandings($group);
            }

            // 4. Reset team statistics and competition winner
            $standingsService->recalculateTeamStatistics($competition);
            $competition->update([
                'status' => 'upcoming',
                'winner_team_id' => null,
            ]);
            $standingsService->syncCompetitionDatesAndStatus($competition);
        });

        $this->info("✔ Tournament reset successfully! All matches are scheduled and standings reset to zero.");
        return Command::SUCCESS;
    }
}
