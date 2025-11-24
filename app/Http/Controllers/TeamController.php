<?php
// app/Http/Controllers/TeamController.php
namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::active()
            ->with('captain', 'members')
            ->latest()
            ->paginate(12);

        return view('teams.index', compact('teams'));
    }

    public function show($slug)
    {
        $team = Team::where('slug', $slug)
            ->with(['captain', 'members', 'tournamentRegistrations.tournament'])
            ->firstOrFail();

        $matches = $team->allMatches()
            ->with(['tournament.game', 'team1', 'team2', 'winner'])
            ->latest()
            ->take(10)
            ->get();

        return view('teams.show', compact('team', 'matches'));
    }

    public function create()
    {
        return view('teams.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:teams',
            'tag' => 'required|string|max:10|unique:teams',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'max_members' => 'required|integer|min:2|max:10',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['captain_id'] = Auth::id();

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')
                ->store('teams/logos', 'public');
        }

        $team = Team::create($validated);

        // Add creator as captain member
        $team->members()->attach(Auth::id(), [
            'role' => 'captain',
            'joined_at' => now(),
            'is_active' => true,
        ]);

        return redirect()->route('teams.show', $team->slug)
            ->with('success', 'Team created successfully!');
    }

    public function edit($slug)
    {
        $team = Team::where('slug', $slug)->firstOrFail();
        $this->authorize('update', $team);
        
        return view('teams.edit', compact('team'));
    }

    public function update(Request $request, $slug)
    {
        $team = Team::where('slug', $slug)->firstOrFail();
        $this->authorize('update', $team);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:teams,name,' . $team->id,
            'tag' => 'required|string|max:10|unique:teams,tag,' . $team->id,
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'max_members' => 'required|integer|min:2|max:10',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')
                ->store('teams/logos', 'public');
        }

        $team->update($validated);

        return redirect()->route('teams.show', $team->slug)
            ->with('success', 'Team updated successfully!');
    }

    public function manageMembers($slug)
    {
        $team = Team::where('slug', $slug)
            ->with(['members', 'captain'])
            ->firstOrFail();
            
        $this->authorize('update', $team);

        // Get users who are not already in the team
        $availableUsers = User::whereDoesntHave('teams', function($q) use ($team) {
            $q->where('team_id', $team->id);
        })->get();

        return view('teams.manage-members', compact('team', 'availableUsers'));
    }

    public function addMember(Request $request, $slug)
    {
        $team = Team::where('slug', $slug)->firstOrFail();
        $this->authorize('update', $team);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:player,substitute',
        ]);

        if ($team->members()->count() >= $team->max_members) {
            return back()->with('error', 'Team is full.');
        }

        $team->members()->attach($request->user_id, [
            'role' => $request->role,
            'joined_at' => now(),
            'is_active' => true,
        ]);

        return back()->with('success', 'Member added successfully!');
    }

    public function removeMember($slug, $userId)
    {
        $team = Team::where('slug', $slug)->firstOrFail();
        $this->authorize('update', $team);

        if ($userId == $team->captain_id) {
            return back()->with('error', 'Cannot remove team captain.');
        }

        $team->members()->detach($userId);

        return back()->with('success', 'Member removed successfully!');
    }
}