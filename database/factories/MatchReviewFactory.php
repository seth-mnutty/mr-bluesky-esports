<?php

// database/factories/MatchReviewFactory.php
namespace Database\Factories;

use App\Models\MatchReview;
use App\Models\Matches;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MatchReviewFactory extends Factory
{
    protected $model = MatchReview::class;

    public function definition(): array
    {
        return [
            'match_id' => Matches::where('status', 'completed')->inRandomOrder()->first()->id ?? Matches::factory()->completed(),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'review_text' => fake()->paragraph(),
            'rating' => rand(1, 5),
            'category' => fake()->randomElement(['gameplay', 'organization', 'fairness', 'overall']),
            'is_approved' => fake()->boolean(85),
        ];
    }
}