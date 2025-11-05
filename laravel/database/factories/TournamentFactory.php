<?php

// database/factories/TournamentFactory.php
namespace Database\Factories;

use App\Models\Tournament;
use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TournamentFactory extends Factory
{
    protected $model = Tournament::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(4, true);
        $regStart = Carbon::now()->addDays(rand(5, 10));
        $regEnd = $regStart->copy()->addDays(14);
        $tourneyStart = $regEnd->copy()->addDays(7);
        
        return [
            'name' => ucwords($name) . ' Championship',
            'slug' => Str::slug($name . '-championship'),
            'description' => fake()->paragraphs(3, true),
            'game_id' => Game::inRandomOrder()->first()->id ?? Game::factory(),
            'organizer_id' => User::where('role', 'organizer')->inRandomOrder()->first()->id ?? User::factory()->organizer(),
            'format' => fake()->randomElement(['single_elimination', 'double_elimination', 'round_robin', 'swiss']),
            'max_teams' => fake()->randomElement([8, 16, 32]),
            'team_size' => 5,
            'prize_pool' => fake()->randomFloat(2, 5000, 50000),
            'banner_image' => 'tournaments/banners/default.jpg',
            'registration_start' => $regStart,
            'registration_end' => $regEnd,
            'tournament_start' => $tourneyStart,
            'tournament_end' => null,
            'status' => 'draft',
            'rules' => json_encode([
                'Check-in required 30 minutes before match',
                'All players must be present',
                'Standard competitive ruleset applies',
            ]),
        ];
    }

    public function upcoming()
    {
        return $this->state(function (array $attributes) {
            $regStart = Carbon::now()->addDays(5);
            $regEnd = $regStart->copy()->addDays(14);
            $tourneyStart = $regEnd->copy()->addDays(7);
            
            return [
                'registration_start' => $regStart,
                'registration_end' => $regEnd,
                'tournament_start' => $tourneyStart,
                'status' => 'registration_open',
            ];
        });
    }

    public function ongoing()
    {
        return $this->state(function (array $attributes) {
            return [
                'registration_start' => Carbon::now()->subDays(30),
                'registration_end' => Carbon::now()->subDays(15),
                'tournament_start' => Carbon::now()->subDays(7),
                'status' => 'ongoing',
            ];
        });
    }
}