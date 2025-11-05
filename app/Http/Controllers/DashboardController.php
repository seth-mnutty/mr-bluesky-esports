<?php
// app/Http/Controllers/Admin/DashboardController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Game;
use App\Models\Tournament;
use App\Models\Team;
use App\Models\Matches;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_games' => Game::count(),
            'total_tournaments' => Tournament::count(),
            'total_teams' => Team::count(),
            'active_tournaments' => Tournament::whereIn('status', ['registration_open', 'ongoing'])->count(),
            'completed_matches' => Matches::where('status', 'completed')->count(),
            'pending_registrations' => \App\Models\TournamentRegistration::where('status', 'pending')->count(),
        ];

        $recentTournaments = Tournament::with('game', 'organizer')
                                      ->latest()
                                      ->take(5)
                                      ->get();

        $recentUsers = User::latest()->take(5)->get();

        $upcomingMatches = Matches::upcoming()
                                ->with('tournament.game', 'team1', 'team2')
                                ->take(5)
                                ->get();

        return view('admin.dashboard', compact('stats', 'recentTournaments', 'recentUsers', 'upcomingMatches'));
    }
}
