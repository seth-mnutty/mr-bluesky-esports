<?php

// database/factories/PlayerPerformanceFactory.php
namespace Database\Factories;

use App\Models\PlayerPerformance;
use App\Models\Matches;
use App\Models\User;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlayerPerformanceFactory extends Factory
{
    protected $model = PlayerPerformance::class;

    public function definition(): array
    {
        $kills = rand(0, 30);
        $deaths = max(1, rand(0, 15)); // At least 1 to avoid division by zero
        $assists = rand(0, 25);
        $kdaRatio = round(($kills + $assists) / $deaths, 2);
        
        return [
            'match_id' => Matches::inRandomOrder()->first()->id ?? Matches::factory(),
            'user_id' => User::where('role', 'player')->inRandomOrder()->first()->id ?? User::factory()->player(),
            'team_id' => Team::inRandomOrder()->first()->id ?? Team::factory(),
            'kills' => $kills,
            'deaths' => $deaths,
            'assists' => $assists,
            'kda_ratio' => $kdaRatio,
            'damage_dealt' => rand(5000, 50000),
            'healing_done' => rand(0, 10000),
            'objectives_captured' => rand(0, 10),
            'accuracy' => fake()->randomFloat(2, 30.00, 95.00),
            'additional_stats' => json_encode([
                'headshots' => rand(0, 20),
                'double_kills' => rand(0, 5),
            ]),
        ];
    }
}