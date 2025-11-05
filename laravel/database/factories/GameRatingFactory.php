<?php

// database/factories/GameRatingFactory.php
namespace Database\Factories;

use App\Models\GameRating;
use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameRatingFactory extends Factory
{
    protected $model = GameRating::class;

    public function definition(): array
    {
        return [
            'game_id' => Game::inRandomOrder()->first()->id ?? Game::factory(),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'rating' => rand(1, 5),
        ];
    }
}

// database/factories/GameReviewFactory.php
namespace Database\Factories;

use App\Models\GameReview;
use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameReviewFactory extends Factory
{
    protected $model = GameReview::class;

    public function definition(): array
    {
        $isApproved = fake()->boolean(80);
        
        return [
            'game_id' => Game::inRandomOrder()->first()->id ?? Game::factory(),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'title' => fake()->sentence(),
            'review_text' => fake()->paragraphs(3, true),
            'rating' => rand(1, 5),
            'helpful_count' => rand(0, 100),
            'is_approved' => $isApproved,
            'approved_at' => $isApproved ? now() : null,
        ];
    }
}
