<?php
// app/Http/Controllers/Admin/GameManagementController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class GameManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $games = Game::withCount(['tournaments', 'ratings', 'reviews'])
                    ->latest()
                    ->paginate(20);

        return view('admin.games.index', compact('games'));
    }

    public function toggleStatus($id)
    {
        $game = Game::findOrFail($id);
        $game->is_active = !$game->is_active;
        $game->save();

        return back()->with('success', 'Game status updated successfully!');
    }

    public function destroy($id)
    {
        $game = Game::findOrFail($id);
        $game->delete();

        return back()->with('success', 'Game deleted successfully!');
    }
}
