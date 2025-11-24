<?php

// app/Http/Controllers/TournamentController.php
namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\Game;
use App\Models\TournamentRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Services\FixtureGeneratorService;

class TournamentController extends Controller
{
    public function index(Request $request)
    {
        $query = Tournament::with('game', 'organizer');

        if ($request->status) {
            if ($request->status === 'upcoming') {
                $query->upcoming();
            } elseif ($request->status === 'ongoing') {
                $query->ongoing();
            } elseif ($request->status === 'completed') {
                $query->completed();
            }
        }

        if ($request->game_id) {
            $query->where('game_id', $request->game_id);
        }

        $tournaments = $query->latest()->paginate(12);
        $games = Game::active()->get();

        return view('tournaments.index', compact('tournaments', 'games'));
    }

    public function show($slug)
    {
        $tournament = Tournament::where('slug', $slug)
            ->with(['game', 'organizer', 'registrations.team', 'matches'])
            ->firstOrFail();

        $registeredTeams = $tournament->registrations()
            ->approved()
            ->with('team.members')
            ->get();

        $upcomingMatches = $tournament->matches()
            ->upcoming()
            ->with('team1', 'team2')
            ->take(5)
            ->get();

        $userCanRegister = false;
        if (Auth::check()) {
            $userTeams = Auth::user()->captainedTeams;
            $userCanRegister = $tournament->canRegister() && $userTeams->count() > 0;
        }

        return view('tournaments.show', compact(
            'tournament',
            'registeredTeams',
            'upcomingMatches',
            'userCanRegister'
        ));
    }

    public function create()
    {
        $this->authorize('create', Tournament::class);
        $games = Game::active()->get();
        
        return view('tournaments.create', compact('games'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Tournament::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'game_id' => 'required|exists:games,id',
            'format' => 'required|in:single_elimination,double_elimination,round_robin,swiss',
            'max_teams' => 'required|integer|min:2',
            'team_size' => 'required|integer|min:1',
            'prize_pool' => 'nullable|numeric|min:0',
            'registration_start' => 'required|date|after:today',
            'registration_end' => 'required|date|after:registration_start',
            'tournament_start' => 'required|date|after:registration_end',
            'banner_image' => 'nullable|image|max:2048',
            'rules' => 'nullable|array',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['organizer_id'] = Auth::id();
        $validated['status'] = 'draft';

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')
                ->store('tournaments/banners', 'public');
        }

        $tournament = Tournament::create($validated);

        return redirect()->route('tournaments.show', $tournament->slug)
            ->with('success', 'Tournament created successfully!');
    }

    public function edit($slug)
    {
        $tournament = Tournament::where('slug', $slug)->firstOrFail();
        $this->authorize('update', $tournament);
        
        $games = Game::active()->get();
        
        return view('tournaments.edit', compact('tournament', 'games'));
    }

    public function update(Request $request, $slug)
    {
        $tournament = Tournament::where('slug', $slug)->firstOrFail();
        $this->authorize('update', $tournament);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'game_id' => 'required|exists:games,id',
            'format' => 'required|in:single_elimination,double_elimination,round_robin,swiss',
            'max_teams' => 'required|integer|min:2',
            'team_size' => 'required|integer|min:1',
            'prize_pool' => 'nullable|numeric|min:0',
            'registration_start' => 'required|date',
            'registration_end' => 'required|date|after:registration_start',
            'tournament_start' => 'required|date|after:registration_end',
            'status' => 'required|in:draft,registration_open,registration_closed,ongoing,completed,cancelled',
            'banner_image' => 'nullable|image|max:2048',
            'rules' => 'nullable|array',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')
                ->store('tournaments/banners', 'public');
        }

        $tournament->update($validated);

        return redirect()->route('tournaments.show', $tournament->slug)
            ->with('success', 'Tournament updated successfully!');
    }

    public function register(Request $request, $slug)
    {
        $tournament = Tournament::where('slug', $slug)->firstOrFail();

        if (!$tournament->canRegister()) {
            return back()->with('error', 'Registration is not available for this tournament.');
        }

        $request->validate([
            'team_id' => 'required|exists:teams,id',
        ]);

        // Check if user is captain of the team
        $team = Auth::user()->captainedTeams()->find($request->team_id);
        if (!$team) {
            return back()->with('error', 'You must be the captain to register the team.');
        }

        // Check if already registered
        $exists = TournamentRegistration::where('tournament_id', $tournament->id)
                                       ->where('team_id', $request->team_id)
                                       ->exists();

        if ($exists) {
            return back()->with('error', 'This team is already registered.');
        }

        TournamentRegistration::create([
            'tournament_id' => $tournament->id,
            'team_id' => $request->team_id,
            'status' => 'approved',
            'registered_at' => now(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Team registered successfully!');
    }

    public function generateFixtures(Request $request, $slug, FixtureGeneratorService $generator)
    {
        $tournament = Tournament::where('slug', $slug)->firstOrFail();
        $this->authorize('update', $tournament);

        try {
            $generator->generateFixtures($tournament);
            return back()->with('success', 'Fixtures generated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function leaderboard($slug)
    {
        $tournament = Tournament::where('slug', $slug)->firstOrFail();
        
        $leaderboard = $tournament->registrations()
            ->approved()
            ->with('team')
            ->orderByDesc('points')
            ->orderByDesc('wins')
            ->orderByDesc('matches_played')
            ->get();

        return view('tournaments.leaderboard', compact('tournament', 'leaderboard'));
    }
}
