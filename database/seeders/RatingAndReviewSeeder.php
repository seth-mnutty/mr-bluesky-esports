<?php

// database/seeders/RatingAndReviewSeeder.php
namespace Database\Seeders;

use App\Models\Game;
use App\Models\GameRating;
use App\Models\GameReview;
use App\Models\Matches;
use App\Models\MatchReview;
use App\Models\User;
use Illuminate\Database\Seeder;

class RatingAndReviewSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating ratings and reviews...');

        $games = Game::all();
        $users = User::whereIn('role', ['player', 'spectator'])->get();
        $completedMatches = Matches::where('status', 'completed')->get();

        if ($games->isEmpty() || $users->isEmpty()) {
            $this->command->error('Missing required data (games or users)!');
            return;
        }

        // Game Ratings (multiple users rate each game)
        $ratingCount = 0;
        foreach ($games as $game) {
            $ratingUsers = $users->random(min(rand(10, 30), $users->count()));
            
            foreach ($ratingUsers as $user) {
                try {
                    GameRating::create([
                        'game_id' => $game->id,
                        'user_id' => $user->id,
                        'rating' => rand(3, 5), // Mostly positive ratings
                    ]);
                    $ratingCount++;
                } catch (\Exception $e) {
                    // Skip if duplicate (user already rated this game)
                    continue;
                }
            }
        }

        // Game Reviews (fewer than ratings)
        $reviewCount = 0;
        foreach ($games as $game) {
            $reviewUsers = $users->random(min(rand(5, 15), $users->count()));
            
            foreach ($reviewUsers as $user) {
                try {
                    GameReview::create([
                        'game_id' => $game->id,
                        'user_id' => $user->id,
                        'title' => $this->generateReviewTitle(),
                        'review_text' => $this->generateReviewText(),
                        'rating' => rand(3, 5),
                        'helpful_count' => rand(0, 50),
                        'is_approved' => rand(0, 100) < 85, // 85% approved
                        'approved_at' => rand(0, 100) < 85 ? now()->subDays(rand(1, 30)) : null,
                    ]);
                    $reviewCount++;
                } catch (\Exception $e) {
                    // Skip if error
                    continue;
                }
            }
        }

        // Update game average ratings
        foreach ($games as $game) {
            $avgRating = GameRating::where('game_id', $game->id)->avg('rating');
            $totalReviews = GameReview::where('game_id', $game->id)->count();
            
            $game->update([
                'average_rating' => round($avgRating ?? 0, 2),
                'total_reviews' => $totalReviews,
            ]);
        }

        // Match Reviews
        $matchReviewCount = 0;
        if ($completedMatches->isNotEmpty()) {
            foreach ($completedMatches as $match) {
                $reviewUsers = $users->random(min(rand(2, 6), $users->count()));
                
                foreach ($reviewUsers as $user) {
                    try {
                        GameReview::create([
                            'match_id' => $match->id,
                            'user_id' => $user->id,
                            'review_text' => $this->generateMatchReviewText(),
                            'rating' => rand(3, 5),
                            'category' => ['gameplay', 'organization', 'fairness', 'overall'][rand(0, 3)],
                            'is_approved' => rand(0, 100) < 90, // 90% approved
                        ]);
                        $matchReviewCount++;
                    } catch (\Exception $e) {
                        // Skip if error
                        continue;
                    }
                }
            }
        }

        $this->command->info('✓ Game Ratings: ' . $ratingCount);
        $this->command->info('✓ Game Reviews: ' . $reviewCount);
        $this->command->info('✓ Match Reviews: ' . $matchReviewCount);
    }

    private function generateReviewTitle()
    {
        $titles = [
            'Amazing gameplay experience!',
            'Great game with some issues',
            'Highly recommended for esports fans',
            'Best competitive game in its genre',
            'Good but needs improvement',
            'Excellent mechanics and balance',
            'Fun but challenging to master',
            'Perfect for competitive play',
            'Engaging and addictive gameplay',
            'Worth every penny',
        ];

        return $titles[array_rand($titles)];
    }

    private function generateReviewText()
    {
        $texts = [
            'This game offers an incredible competitive experience with well-balanced gameplay mechanics. The skill ceiling is high, making it rewarding for dedicated players. The esports scene is thriving and matches are always exciting to watch.',
            'After playing for several months, I can confidently say this is one of the best esports titles available. The learning curve is steep but fair, and the community is generally welcoming to newcomers.',
            'Great game overall with regular updates and new content. The competitive scene is very active with frequent tournaments. However, there are occasional balance issues that need addressing.',
            'The gameplay is solid and the competitive scene is well-established. Perfect for both casual and competitive players. The tournaments are professionally organized and exciting to participate in.',
            'An excellent esports title with deep strategic gameplay. The skill-based mechanics make every match feel rewarding. Highly recommended for anyone interested in competitive gaming.',
        ];

        return $texts[array_rand($texts)];
    }

    private function generateMatchReviewText()
    {
        $texts = [
            'Excellent match with great plays from both teams. The organization was smooth and professional.',
            'Very competitive and exciting to watch. Both teams showed impressive skills.',
            'Well organized tournament match with fair gameplay and good sportsmanship.',
            'Amazing performance from both sides. The match lived up to expectations.',
            'Great tournament experience. The match was intense and entertaining throughout.',
        ];

        return $texts[array_rand($texts)];
    }
}