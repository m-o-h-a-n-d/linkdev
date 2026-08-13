<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\CompetitionGroup;
use App\Models\GameMatch;
use App\Models\Team;
use App\Services\Match\FixtureGeneratorService;
use App\Services\Match\MatchLiveStatusService;
use App\Services\Match\MatchStandingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MatchController extends Controller
{
    public function __construct(
        protected MatchLiveStatusService $liveStatusService,
        protected MatchStandingsService $standingsService,
        protected FixtureGeneratorService $fixtureGeneratorService
    ) {}

    public function index(Request $request): View
    {
        // Trigger auto live status update check
        $this->liveStatusService->checkAndUpdateLiveStatuses();

        $query = GameMatch::with(['competition', 'group', 'homeTeam', 'awayTeam']);

        if ($request->filled('competition_id')) {
            $query->where('competition_id', $request->competition_id);
        }

        if ($request->filled('group_id')) {
            $query->where('group_id', $request->group_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $matches = $query->orderBy('scheduled_at', 'desc')->paginate(15);
        $competitions = Competition::all();
        $groups = CompetitionGroup::all();

        return view('backend.matches.index', compact('matches', 'competitions', 'groups'));
    }

    public function create(): View
    {
        $competitions = Competition::with('groups', 'teams')->get();
        $groups = CompetitionGroup::with('teams')->get();
        $teams = Team::all();

        return view('backend.matches.create', compact('competitions', 'groups', 'teams'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'competition_id' => 'required|exists:competitions,id',
            'group_id' => 'nullable|exists:competition_groups,id',
            'home_team_id' => 'required|exists:teams,id|different:away_team_id',
            'away_team_id' => 'required|exists:teams,id',
            'scheduled_at' => 'required|date',
            'round_number' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:255',
        ]);

        $validated['status'] = 'scheduled';
        $validated['home_score'] = 0;
        $validated['away_score'] = 0;

        GameMatch::create($validated);

        return redirect()->route('admin.matches.index')
            ->with('success', 'Match created and scheduled successfully!');
    }

    public function generateFixtures(Request $request): RedirectResponse
    {
        $request->validate([
            'group_id' => 'required|exists:competition_groups,id',
        ]);

        $group = CompetitionGroup::with('teams')->findOrFail($request->group_id);

        $createdMatches = $this->fixtureGeneratorService->generateGroupFixtures($group);

        if ($createdMatches->isEmpty()) {
            return redirect()->back()->with('error', 'Not enough teams in this group to generate fixtures.');
        }

        return redirect()->route('admin.matches.index')
            ->with('success', "Generated {$createdMatches->count()} fixtures for group: {$group->name}");
    }

    public function show(int $id): View
    {
        $match = GameMatch::with(['competition', 'group', 'homeTeam', 'awayTeam', 'winnerTeam'])->findOrFail($id);
        $elapsedMinutes = $this->liveStatusService->getElapsedMinutes($match);

        return view('backend.matches.show', compact('match', 'elapsedMinutes'));
    }

    public function edit(int $id): View
    {
        $match = GameMatch::findOrFail($id);
        $competitions = Competition::all();
        $groups = CompetitionGroup::all();
        $teams = Team::all();

        return view('backend.matches.edit', compact('match', 'competitions', 'groups', 'teams'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $match = GameMatch::findOrFail($id);

        $validated = $request->validate([
            'scheduled_at' => 'required|date',
            'home_score' => 'required|integer|min:0',
            'away_score' => 'required|integer|min:0',
            'status' => 'required|in:scheduled,live,finished,postponed,cancelled',
            'notes' => 'nullable|string|max:255',
        ]);

        if ($validated['status'] === 'live' && $match->status !== 'live') {
            $now = now();
            $validated['scheduled_at'] = $now;
            $validated['started_at'] = $now;
        }

        if ($validated['status'] === 'finished') {
            if ($validated['home_score'] > $validated['away_score']) {
                $validated['winner_team_id'] = $match->home_team_id;
            } elseif ($validated['away_score'] > $validated['home_score']) {
                $validated['winner_team_id'] = $match->away_team_id;
            } else {
                $validated['winner_team_id'] = null; // Draw
            }
            $validated['ended_at'] = now();
        }

        $match->update($validated);

        // Recalculate Standings & Team Stats
        if ($match->group) {
            $this->standingsService->recalculateGroupStandings($match->group);
        }
        if ($match->competition) {
            $this->standingsService->recalculateTeamStatistics($match->competition);
        }

        // Advance knockout winner if finished
        if ($match->status === 'finished') {
            $this->standingsService->advanceKnockoutWinner($match);
        }

        return redirect()->route('admin.matches.index')
            ->with('success', 'Match updated and standings recalculated successfully!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $match = GameMatch::findOrFail($id);
        $group = $match->group;
        $competition = $match->competition;

        $match->delete();

        if ($group) {
            $this->standingsService->recalculateGroupStandings($group);
        }
        if ($competition) {
            $this->standingsService->recalculateTeamStatistics($competition);
        }

        return redirect()->route('admin.matches.index')
            ->with('success', 'Match deleted successfully.');
    }

    public function liveCenter(Request $request): View
    {
        $this->liveStatusService->checkAndUpdateLiveStatuses();

        $liveMatches = GameMatch::with(['homeTeam', 'awayTeam', 'group', 'competition'])
            ->whereIn('status', ['live', 'scheduled'])
            ->orderBy('scheduled_at', 'asc')
            ->get();

        return view('backend.matches.live-center', compact('liveMatches'));
    }

    public function updateScore(Request $request, int $id): RedirectResponse
    {
        $match = GameMatch::findOrFail($id);

        $request->validate([
            'action' => 'required|in:increment_home,decrement_home,increment_away,decrement_away,start_live,finish_match',
        ]);

        $action = $request->action;

        if ($action === 'start_live') {
            $now = now();
            $match->update([
                'status' => 'live',
                'scheduled_at' => $now,
                'started_at' => $now,
            ]);
            $this->liveStatusService->sendLiveNotification($match);
        } elseif ($action === 'increment_home') {
            $match->increment('home_score');
        } elseif ($action === 'decrement_home' && $match->home_score > 0) {
            $match->decrement('home_score');
        } elseif ($action === 'increment_away') {
            $match->increment('away_score');
        } elseif ($action === 'decrement_away' && $match->away_score > 0) {
            $match->decrement('away_score');
        } elseif ($action === 'finish_match') {
            $winnerId = null;
            if ($match->home_score > $match->away_score) {
                $winnerId = $match->home_team_id;
            } elseif ($match->away_score > $match->home_score) {
                $winnerId = $match->away_team_id;
            }

            $startedAt = $match->started_at ?? $match->scheduled_at ?? now();

            $match->update([
                'status' => 'finished',
                'winner_team_id' => $winnerId,
                'started_at' => $startedAt,
                'ended_at' => now(),
            ]);

            // Trigger standings recalculation
            if ($match->group) {
                $this->standingsService->recalculateGroupStandings($match->group);
            }
            if ($match->competition) {
                $this->standingsService->recalculateTeamStatistics($match->competition);
            }

            // Trigger knockout advancement
            $this->standingsService->advanceKnockoutWinner($match);
        }

        return redirect()->back()->with('success', 'Match updated successfully!');
    }
}
