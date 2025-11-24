<?php

// app/Http/Controllers/MatchController.php
namespace App\Http\Controllers;

use App\Models\Matches;
use App\Models\Tournament;
use App\Models\PlayerPerformance;
use App\Models\TournamentRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MatchController extends Controller
{
    public function index()
    {
        $upcomingMatches = Matches::upcoming()
                                ->with('tournament.game', 'team1', 'team2')
                                ->paginate(10, ['*'], 'upcoming');

        $liveMatches = Matches::live()
            ->with('tournament.game', 'team1', 'team2')
            ->get();

        $completedMatches = Matches::completed()
            ->with('tournament.game', 'team1', 'team2', 'winner')
            ->latest('completed_at')
            ->paginate(10, ['*'], 'completed');

        return view('matches.index', compact('upcomingMatches', 'liveMatches', 'completedMatches'));
    }

    public function show($id)
    {
        $match = Matches::with([
            'tournament.game',
            'team1.members',
            'team2.members',
            'winner',
            'playerPerformances.player',
            'reviews.user'
        ])->findOrFail($id);

        return view('matches.show', compact('match'));
    }

    public function create($tournamentSlug)
    {
        $tournament = Tournament::where('slug', $tournamentSlug)->firstOrFail();
        $this->authorize('update', $tournament);

        $registeredTeams = $tournament->registrations()
            ->approved()
            ->with('team')
            ->get()
            ->pluck('team');

        return view('matches.create', compact('tournament', 'registeredTeams'));
    }

    public function store(Request $request, $tournamentSlug)
    {
        $tournament = Tournament::where('slug', $tournamentSlug)->firstOrFail();
        $this->authorize('update', $tournament);

        $validated = $request->validate([
            'team1_id' => 'required|exists:teams,id',
            'team2_id' => 'required|exists:teams,id|different:team1_id',
            'round' => 'required|integer|min:1',
            'match_number' => 'required|integer|min:1',
            'scheduled_at' => 'required|date|after:now',
            'stream_url' => 'nullable|url',
            'notes' => 'nullable|string',
        ]);

        $validated['tournament_id'] = $tournament->id;
        $validated['status'] = 'scheduled';

        $match = Matches::create($validated);

        return redirect()->route('tournaments.show', $tournament->slug)
                        ->with('success', 'Match created successfully!');
    }

    public function updateScore(Request $request, $id)
    {
        $match = Matches::findOrFail($id);
        $this->authorize('update', $match->tournament);

        $validated = $request->validate([
            'team1_score' => 'required|integer|min:0',
            'team2_score' => 'required|integer|min:0',
            'status' => 'required|in:scheduled,live,completed',
        ]);

        $updateData = $validated;

        if ($validated['status'] === 'live' && !$match->started_at) {
            $updateData['started_at'] = now();
        }

        if ($validated['status'] === 'completed') {
            $updateData['completed_at'] = now();
            $updateData['winner_id'] = $validated['team1_score'] > $validated['team2_score'] 
                ? $match->team1_id 
                : $match->team2_id;

            // Update team win rates
            $match->team1->updateWinRate();
            $match->team2->updateWinRate();

            // Update Tournament Leaderboard
            $this->updateLeaderboard($match, $validated['team1_score'], $validated['team2_score']);
        }

        $match->update($updateData);

        return back()->with('success', 'Match score updated successfully!');
    }

    public function addPerformance(Request $request, $id)
    {
        $match = Matches::findOrFail($id);
        $this->authorize('update', $match->tournament);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'team_id' => 'required|exists:teams,id',
            'kills' => 'required|integer|min:0',
            'deaths' => 'required|integer|min:0',
            'assists' => 'required|integer|min:0',
            'damage_dealt' => 'nullable|integer|min:0',
            'healing_done' => 'nullable|integer|min:0',
            'objectives_captured' => 'nullable|integer|min:0',
            'accuracy' => 'nullable|numeric|min:0|max:100',
        ]);

        $validated['match_id'] = $match->id;

        $performance = PlayerPerformance::create($validated);
        $performance->calculateKDA();

        return back()->with('success', 'Player performance added successfully!');
    }

    private function updateLeaderboard(Matches $match, $score1, $score2)
    {
        $reg1 = TournamentRegistration::where('tournament_id', $match->tournament_id)
            ->where('team_id', $match->team1_id)
            ->first();

        $reg2 = TournamentRegistration::where('tournament_id', $match->tournament_id)
            ->where('team_id', $match->team2_id)
            ->first();

        if ($reg1 && $reg2) {
            $reg1->increment('matches_played');
            $reg2->increment('matches_played');

            if ($score1 > $score2) {
                $reg1->increment('wins');
                $reg1->increment('points', 3);
                $reg2->increment('losses');
            } elseif ($score2 > $score1) {
                $reg2->increment('wins');
                $reg2->increment('points', 3);
                $reg1->increment('losses');
            } else {
                $reg1->increment('draws');
                $reg1->increment('points', 1);
                $reg2->increment('draws');
                $reg2->increment('points', 1);
            }
        }
    }
}
