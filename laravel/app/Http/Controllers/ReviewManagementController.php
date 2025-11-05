<?php
//  app/Http/Controllers/Admin/ReviewManagementController.php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameReview;
use App\Models\MatchReview;
use Illuminate\Http\Request;

class ReviewManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function gameReviews()
    {
        $reviews = GameReview::with('game', 'user')
            ->latest()
            ->paginate(20);

        return view('admin.reviews.game-reviews', compact('reviews'));
    }

    public function approveGameReview($id)
    {
        $review = GameReview::findOrFail($id);
        $review->update([
            'is_approved' => true,
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Review approved successfully!');
    }

    public function rejectGameReview($id)
    {
        $review = GameReview::findOrFail($id);
        $review->delete();

        return back()->with('success', 'Review rejected and deleted!');
    }

    public function matchReviews()
    {
        $reviews = MatchReview::with('match.tournament', 'user')
            ->latest()
            ->paginate(20);

        return view('admin.reviews.match-reviews', compact('reviews'));
    }

    public function approveMatchReview($id)
    {
        $review = MatchReview::findOrFail($id);
        $review->update(['is_approved' => true]);

        return back()->with('success', 'Match review approved successfully!');
    }

    public function rejectMatchReview($id)
    {
        $review = MatchReview::findOrFail($id);
        $review->delete();

        return back()->with('success', 'Match review rejected and deleted!');
    }
}
