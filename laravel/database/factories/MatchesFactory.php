<?php

// database/factories/MatchFactory.php
namespace Database\Factories;

use App\Models\Matches;
use App\Models\Tournament;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class MatchFactory extends Factory
{
    protected $model = Matches::class;

    public function definition(): array
    {
        $scheduledAt = Carbon::now()->addDays(rand(1, 30));
        
        return [
            'tournament_id' => Tournament::inRandomOrder()->first()->id ?? Tournament::factory(),
            'team1_id' => Team::inRandomOrder()->first()->id ?? Team::factory(),
            'team2_id' => Team::where('id', '!=', $this->faker->randomElement(Team::pluck('id')->toArray()))->inRandomOrder()->first()->id ?? Team::factory(),
            'round' => fake()->numberBetween(1, 5),
            'match_number' => fake()->numberBetween(1, 32),
            'scheduled_at' => $scheduledAt,
            'started_at' => null,
            'completed_at' => null,
            'team1_score' => null,
            'team2_score' => null,
            'winner_id' => null,
            'status' => 'scheduled',
            'stream_url' => 'https://twitch.tv/esports',
            'notes' => null,
        ];
    }

    public function completed()
    {
        return $this->state(function (array $attributes) {
            $team1Score = rand(0, 3);
            $team2Score = rand(0, 3);
            
            // Ensure different scores
            while ($team1Score === $team2Score) {
                $team2Score = rand(0, 3);
            }
            
            return [
                'started_at' => Carbon::now()->subHours(3),
                'completed_at' => Carbon::now()->subHours(1),
                'team1_score' => $team1Score,
                'team2_score' => $team2Score,
                'winner_id' => $team1Score > $team2Score ? $attributes['team1_id'] : $attributes['team2_id'],
                'status' => 'completed',
            ];
        });
    }

    public function live()
    {
        return $this->state(function (array $attributes) {
            return [
                'started_at' => Carbon::now()->subMinutes(30),
                'status' => 'live',
            ];
        });
    }
}
