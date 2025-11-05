<?php

/**  app/Http/Controllers/HomeController.php  */
namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Tournament;
use App\Models\Matches;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredGames = Game::active()
            ->orderBy('average_rating', 'desc')
            ->take(6)
            ->get();

        $upcomingTournaments = Tournament::upcoming()
            ->with('game', 'organizer')
            ->take(4)
            ->get();

        $ongoingTournaments = Tournament::ongoing()
            ->with('game', 'organizer')
            ->take(3)
            ->get();

        $upcomingMatches = Matches::upcoming()
            ->with('tournament.game', 'team1', 'team2')
            ->take(5)
            ->get();

        return view('home', compact(
            'featuredGames',
            'upcomingTournaments',
            'ongoingTournaments',
            'upcomingMatches'
        ));
    }
}
