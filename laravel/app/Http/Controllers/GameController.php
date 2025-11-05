<?php
// app/Http/Controllers/GameController.php
namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameRating;
use App\Models\GameReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::active()
            ->with('creator')
            ->latest()
            ->paginate(12);

        return view('games.index', compact('games'));
    }

    public function show($slug)
    {
        $game = Game::where('slug', $slug)
                    ->with(['creator', 'tournaments' => function($query) {
                        $query->latest()->take(5);
                    }])
                    ->firstOrFail();

        $reviews = GameReview::where('game_id', $game->id)
                            ->approved()
                            ->with('user')
                            ->latest()
                            ->paginate(10);

        $userRating = null;
        if (Auth::check()) {
            $userRating = GameRating::where('game_id', $game->id)
                                    ->where('user_id', Auth::id())
                                    ->first();
        }

        return view('games.show', compact('game', 'reviews', 'userRating'));
    }

    public function create()
    {
        $this->authorize('create', Game::class);
        return view('games.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Game::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:games',
            'description' => 'required|string',
            'genre' => 'required|string',
            'publisher' => 'nullable|string',
            'release_date' => 'nullable|date',
            'platform' => 'required|in:PC,PlayStation,Xbox,Mobile,Cross-platform',
            'min_players' => 'required|integer|min:1',
            'max_players' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['created_by'] = Auth::id();

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')
                ->store('games/covers', 'public');
        }

        $game = Game::create($validated);

        return redirect()->route('games.show', $game->slug)
                        ->with('success', 'Game created successfully!');
    }

    public function edit($slug)
    {
        $game = Game::where('slug', $slug)->firstOrFail();
        $this->authorize('update', $game);
        
        return view('games.edit', compact('game'));
    }

    public function update(Request $request, $slug)
    {
        $game = Game::where('slug', $slug)->firstOrFail();
        $this->authorize('update', $game);

        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:games,title,' . $game->id,
            'description' => 'required|string',
            'genre' => 'required|string',
            'publisher' => 'nullable|string',
            'release_date' => 'nullable|date',
            'platform' => 'required|in:PC,PlayStation,Xbox,Mobile,Cross-platform',
            'min_players' => 'required|integer|min:1',
            'max_players' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')
                ->store('games/covers', 'public');
        }

        $game->update($validated);

        return redirect()->route('games.show', $game->slug)
                        ->with('success', 'Game updated successfully!');
    }

    public function destroy($slug)
    {
        $game = Game::where('slug', $slug)->firstOrFail();
        $this->authorize('delete', $game);

        $game->delete();

        return redirect()->route('games.index')
                        ->with('success', 'Game deleted successfully!');
    }

    public function rate(Request $request, $slug)
    {
        $game = Game::where('slug', $slug)->firstOrFail();

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        GameRating::updateOrCreate(
            [
                'game_id' => $game->id,
                'user_id' => Auth::id(),
            ],
            [
                'rating' => $request->rating,
            ]
        );

        return back()->with('success', 'Rating submitted successfully!');
    }
}
