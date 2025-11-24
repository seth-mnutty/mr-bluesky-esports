<?php
// app/Http/Controllers/ReviewController.php
namespace App\Http\Controllers;

use App\Models\GameReview;
use App\Models\MatchReview;
use App\Models\Game;
use App\Models\Matches;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Game Reviews
    public function storeGameReview(Request $request, $slug)
    {
        $game = Game::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'review_text' => 'required|string|min:10',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $validated['game_id'] = $game->id;
        $validated['user_id'] = Auth::id();
        $validated['is_approved'] = true;
        $validated['approved_at'] = now();

        GameReview::create($validated);

        return back()->with('success', 'Review submitted successfully!');
    }

    public function updateGameReview(Request $request, $id)
    {
        $review = GameReview::findOrFail($id);
        $this->authorize('update', $review);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'review_text' => 'required|string|min:50',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $review->update($validated);

        return back()->with('success', 'Review updated successfully!');
    }

    public function deleteGameReview($id)
    {
        $review = GameReview::findOrFail($id);
        $this->authorize('delete', $review);

        $review->delete();

        return back()->with('success', 'Review deleted successfully!');
    }

    public function markGameReviewHelpful($id)
    {
        $review = GameReview::findOrFail($id);
        $review->increment('helpful_count');

        return back()->with('success', 'Thank you for your feedback!');
    }

    // Match Reviews
    public function storeMatchReview(Request $request, $id)
    {
        $match = GameReview::findOrFail($id);

        $validated = $request->validate([
            'review_text' => 'required|string|min:20',
            'rating' => 'required|integer|min:1|max:5',
            'category' => 'required|in:gameplay,organization,fairness,overall',
        ]);

        $validated['match_id'] = $match->id;
        $validated['user_id'] = Auth::id();
        $validated['is_approved'] = true;
        $validated['approved_at'] = now();

        GameReview::create($validated);

        return back()->with('success', 'Match review submitted successfully!');
    }

    public function updateMatchReview(Request $request, $id)
    {
        $review = GameReview::findOrFail($id);
        $this->authorize('update', $review);

        $validated = $request->validate([
            'review_text' => 'required|string|min:20',
            'rating' => 'required|integer|min:1|max:5',
            'category' => 'required|in:gameplay,organization,fairness,overall',
        ]);

        $review->update($validated);

        return back()->with('success', 'Review updated successfully!');
    }

    public function deleteMatchReview($id)
    {
        $review = GameReview::findOrFail($id);
        $this->authorize('delete', $review);

        $review->delete();

        return back()->with('success', 'Review deleted successfully!');
    }
}
