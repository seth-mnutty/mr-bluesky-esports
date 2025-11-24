<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\TournamentRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Calculate Joined Tournaments Count
        // Get all teams the user is part of (captain or member)
        $teamIds = $user->teams()->pluck('teams.id')
            ->merge($user->captainedTeams()->pluck('id'))
            ->unique();
            
        $joinedTournamentsCount = TournamentRegistration::whereIn('team_id', $teamIds)
            ->count();

        // Calculate Reviews Count
        $reviewsCount = $user->gameReviews()->count() + $user->matchReviews()->count();

        // Fetch Upcoming Tournaments
        $upcomingTournaments = Tournament::whereIn('status', ['scheduled', 'open'])
            ->orderBy('tournament_start', 'asc')
            ->take(4)
            ->get();

        return view('dashboard', compact('joinedTournamentsCount', 'reviewsCount', 'upcomingTournaments'));
    }
}
